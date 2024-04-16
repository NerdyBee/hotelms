<?php
$today_date = date('d/m/Y');

// exec('C:/xampp/mysql/bin/mysqldump.exe --user=root --password= --host=localhost lamonde > C:/Users/ADMIN/Documents/backup/backup.sql');
// exec('mysqldump --user=root --password= --host=localhost lamonde > C:/Users/ADMIN/Documents/backup/backup.sql');
exec('C:/wamp64/bin/mysql/mysql8.0.31/bin/mysqldump --user=root --password= --host=localhost lamonde > C:/Users/ADMIN/Documents/backup/backup.sql');

header("Location: index.php?user_dashboard&msg=backup success");
?>