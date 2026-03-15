<?php
class KLHKFunction {

    function postcurl($url, $curl_header, $curl_data) {
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        $statuscode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);      
        return [
            'statuscode' => $statuscode,
            'response' => $output
        ];
    }

    function getparameter($con) {
        $parameters = array();
        $sqlgetparam = "SELECT * FROM parameter WHERE parameter_status = 'active'";
        $getparamquery = $con->query($sqlgetparam);
        while($row = $getparamquery->fetch_assoc()) {
            $parameter = array();
            $parameterCode = $row['parameter_code'];
            $parameter['code'] = $parameterCode;
            $parameter['parameter_name'] = $row['parameter_name'];
            $parameters[] = $parameter;
        }
        return $parameters;
    }

    function getcerobong($con) {
        $cerobongs = array();
        $sql = "SELECT * FROM cerobong WHERE cerobong_kirim_status = '1'";
        $getparamquery = $con->query($sql);
        while($row = $getparamquery->fetch_assoc()) {
            $cerobong = array();
            $cerobong['cerobong_code'] = $row['cerobong_code'];
            $cerobong['cerobong_name'] = $row['cerobong_name'];
            $cerobong['cerobong_id'] = $row['cerobong_id'];
            $cerobongs[] = $cerobong;
        }
        return $cerobongs;
    }

    function getdata($con, $past, $now, $cerobong_id, $parameter) {
        $datas = array();
        $sql = "SELECT * FROM data WHERE waktu BETWEEN '$past' AND '$now' AND cerobong_id = '$cerobong_id' AND parameter = '$parameter'";
        $getparamquery = $con->query($sql);
        while($row = $getparamquery->fetch_assoc()) {
            $data = array();
            $data['waktu'] = $row['waktu'];
            $data['value'] = $row['value'];
            $data['laju_alir'] = $row['laju_alir'];
            $datas[] = $data;
        }
        return $datas;
    }

    function getnotkirimdata($con) {
        $logs = array();
        $now = date('Y-m-d H:i:s');
        $past = date('Y-m-d H:i:s', strtotime('-23 hours', strtotime($now)));
        $sql = "SELECT * FROM log_kirim_data WHERE status <> 200 AND date_start BETWEEN '$past' AND '$now'";
        $getparamquery = $con->query($sql);
        while($row = $getparamquery->fetch_assoc()) {
            $logs[] = $row['date_start'];
        }
        return $logs;
    }

    function savetoken($con, $token) {
        $t = date('Y-m-d H:i:s');
        $sql = "UPDATE token SET token = '$token', updated_at='$t' WHERE id=1";
        if ($con->query($sql) === TRUE) {
            return "Record updated successfully";
        } else {
            return "Error updating record: " . $con->error;
        }
    }

    function savelog($con, $status, $log) {
        $t = date('Y-m-d H:i:s');
        $sql = "INSERT log_all_status_api (status, log, created_at) VALUES ('$status', '$log', '$t')";
        if ($con->query($sql) === TRUE) {
            return "Record updated successfully";
        } else {
            return "Error updating record: " . $con->error;
        }
    }

    function savelogkirim($con, $date_start, $status, $log) {
        $t = date('Y-m-d H:i:s');
        $sql = "INSERT log_kirim_data (date_start, status, log, created_at, updated_at) VALUES ('$date_start','$status', '$log', '$t', '$t')";
        if ($con->query($sql) === TRUE) {
            return "Record updated successfully";
        } else {
            return "Error updating record: " . $con->error;
        }
    }

    function updatelogkirim($con, $date_start, $status, $log) {
        $t = date('Y-m-d H:i:s');
        $sql = "UPDATE log_kirim_data SET status = '$status', log='$log', updated_at='$t' WHERE date_start='$date_start'";
        if ($con->query($sql) === TRUE) {
            return "Record updated successfully";
        } else {
            return "Error updating record: " . $con->error;
        }
    }

    function updatedatakirim($con, $now) {
        $past = date('Y-m-d H:i:s', strtotime('-59 minutes', strtotime($now))); 
        $sql = "UPDATE data SET status_sispek = 'Terkirim' WHERE waktu between '$past' AND '$now'";
        if ($con->query($sql) === TRUE) {
            return "Record updated successfully";
        } else {
            return "Error updating record: " . $con->error;
        }
    }

    function getconfig($con, $param) {
        $sql = "SELECT config_value FROM config WHERE config_name = '$param'";
        $getparamquery = $con->query($sql);
        $url = $getparamquery->fetch_array(MYSQLI_ASSOC);
        $data = $url['config_value'];
        return $data;
    }

    function saveconfig($con, $param, $value) {
        $sql = "UPDATE config SET config_value = '$value' WHERE config_name='$param'";
        if ($con->query($sql) === TRUE) {
            return "Record updated successfully";
        } else {
            return "Error updating record: " . $con->error;
        }
    }

    function getdbtoken($con) {
        $sql = "SELECT token FROM token WHERE id = 1";
        $getparamquery = $con->query($sql);
        $url = $getparamquery->fetch_array(MYSQLI_ASSOC);
        $data = $url['token'];
        return $data;
    }

    function countdbtoken($con) {
        $now = date('Y-m-d H:00:00');
        $past = date('Y-m-d H:i:s', strtotime('-59 minutes', strtotime($now)));
        $sql = "SELECT token FROM token WHERE updated_at > '$past'";
        $getparamquery = $con->query($sql);
        $count = $getparamquery->num_rows;
        return $count;
    }

    function countdblogkirim($con, $datetime) {
        $sql = "SELECT * FROM log_kirim_data WHERE date_start = '$datetime'";
        $getparamquery = $con->query($sql);
        $count = $getparamquery->num_rows;
        return $count;
    }

    function get_token($con, $curl_header, $url, $url_token) {
        $fullurltoken = $url.$url_token;
        $client_id = client_id();
        $secret_id = secret_id();
        $key = md5($client_id.$secret_id);
        $logindata = array();
        $logindata['app_id'] = $client_id;
        $logindata['app_pwd_hash'] = $key;
        $send = $this->postcurl($fullurltoken, $curl_header, json_encode($logindata));
        return $send;
    }

    function submit($con, $interval, $now){
        $past = date('Y-m-d H:i:s', strtotime('-59 minutes', strtotime($now))); 
        $count = 0;
        $datasubmit = array();
        
        $cerobongs = $this->getcerobong($con);
        foreach($cerobongs as $cerobong){
            $id = $cerobong['cerobong_id'];
            $cerobong_code = $cerobong['cerobong_code'];
            $name = $cerobong['cerobong_name'];
            $dataparameter = array();
            $alldata = array();
            $datas = array();
            $dataparameter['kode_cerobong'] = $cerobong_code;
            $dataparameter['interval'] = $interval;
            $parameters = $this->getparameter($con);
            foreach($parameters as $parameter){
                $data = array();
                $code = $parameter['code'];
                $data[$code] = $this->getdata($con, $past, $now, $id, $code);
                $count = count($data[$code]);
                $datas[] = $data;
            }

            for($a=0; $a < $count; $a++){
                $dataarray = array();
                $b = 0;
                foreach($parameters as $parameter){
                    $parametername = $parameter['parameter_name'];
                    $code = $parameter['code'];
                    $dataarray[$parametername] = $datas[$b][$code][$a]['value'];
                    $b++;
                }
                $dataarray['laju_alir'] = $datas[$b-1][$code][$a]['laju_alir'];
                $dataarray['waktu'] = $datas[$b-1][$code][$a]['waktu'];
                $alldata[] = $dataarray;
            }
            $dataparameter['parameter'] = $alldata;
            $datasubmit[] = $dataparameter;
        }
        return json_encode(['data' => $datasubmit]);
    }
}
