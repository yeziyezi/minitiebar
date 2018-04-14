####版本信息
提交时间 2018-4-14 
版本 v1.0
####部署到服务器上的方法
1. 将 /etc/mysqlinfo.php和/lib/PDOtool.php中的host,db_username,db_password,db_name改成自己数据库的host,username,password以及所使用的mysql 数据库名
2. 新建一个数据库，切换到该数据库。所用的建表sql都在sql文件夹中（mysql版本），可以source执行也可以手动复制sql语句。注意先建完表后再执行insert_bars.sql。
3. 将除sql文件夹以外的其他文件夹扔到apache的document root下面（或者其他服务器的类似文件夹）
4. 搞定
5. 注意：虽然使用的是PHP的PDO类及其封装，使用非mysql的数据库时仍可能需要修改sql语句。
####我的联系方式
escyezi@foxmail.com

