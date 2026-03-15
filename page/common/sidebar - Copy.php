			<div class="main-menu-content">
				<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
					<li class="nav-item<?php if ($p == 'dashboard') { echo ' active'; } ?>"><a href="./"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a></li>
					<li><a href="#"><i class="feather icon-list"></i><span class="menu-title" data-i18n="Lihat Data">Lihat Data</span></a>
						<ul class="menu-content">
<?php
if (isset($_GET['q'])) {
	$q = input($_GET['q']);
}
$cerobongQuery = mysqli_query($con, "select * from cerobong");
while ($cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC)) {
?>
							<li<?php if ($p == 'cerobong' && $q == $cerobongData['cerobong_id']) { echo ' class="active"'; } ?>><a href="cerobong/<?php echo $cerobongData['cerobong_id']; ?>"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="<?php echo $cerobongData['cerobong_name']; ?>"><?php echo $cerobongData['cerobong_name']; ?></span></a></li>
<?php
}
?>
						</ul>
					</li>
					<li class="nav-item<?php if ($p == 'profile') { echo ' active'; } ?>"><a href="profile"><i class="feather icon-globe"></i><span class="menu-title" data-i18n="Profil Perusahaan">Profil Perusahaan</span></a></li>
					<li class="nav-item<?php if ($p == 'maintenance') { echo ' active'; } ?>"><a href="maintenance"><i class="feather icon-command"></i><span class="menu-title" data-i18n="Maintenance">Maintenance</span></a></li>
					<!--
					<li class="nav-item<?php if ($p == 'activity') { echo ' active'; } ?>"><a href="activity"><i class="feather icon-activity"></i><span class="menu-title" data-i18n="Activity">Activity</span></a></li>
					-->
					<li class="nav-item<?php if ($p == 'user') { echo ' active'; } ?>"><a href="user"><i class="feather icon-users"></i><span class="menu-title" data-i18n="User">User</span></a></li>
					<!--
					<li class="nav-item<?php if ($p == 'csv') { echo ' active'; } ?>"><a href="csv"><i class="feather icon-upload"></i><span class="menu-title" data-i18n="Upload CSV">Upload CSV</span></a></li>
					<li class="nav-item<?php if ($p == 'report') { echo ' active'; } ?>"><a href="report"><i class="feather icon-bar-chart-2"></i><span class="menu-title" data-i18n="Laporan">Laporan</span></a></li>
					-->
					<li><a href="#"><i class="feather icon-bar-chart-2"></i><span class="menu-title" data-i18n="Laporan">Laporan</span></a>
						<ul class="menu-content">
							<li<?php if ($p == 'reportbydaterange') { echo ' class="active"'; } ?>><a href="reportbydaterange"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Antar Tanggal">Antar Tanggal</span></a></li>
							<li<?php if ($p == 'reportbydate') { echo ' class="active"'; } ?>><a href="reportbydate"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Per Tanggal">Per Tanggal</span></a></li>
							<li<?php if ($p == 'reportbymonth') { echo ' class="active"'; } ?>><a href="reportbymonth"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Per Bulan">Per Bulan</span></a></li>
							<li<?php if ($p == 'reportbyyear') { echo ' class="active"'; } ?>><a href="reportbyyear"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Per Tahun">Per Tahun</span></a></li>
						</ul>
					</li>
				</ul>
			</div>