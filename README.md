# **EVL-Router-filter**

Is for filtering and storing evl logs from routers.

supported format for .evl file is "2179_2018123122.evl"

2179 -> router id, 2018 -> year, 12 -> mount, 31 -> day, 22 -> id of file 

## **Setup**

1) Setup your server with Apache, PHP and Mysql/Marinadb
2) look in config.php in text editor
3) open index.php in your browser
4) put your .evl files in folder "files"
5) click on "Import to DB" (it may take a while)

## **Changelog**

- [changelog.md](changelog.md)

## **Testing** (I5-5257U 2,7Ghz  8GB ram)

#### v0.5

- test.evl (42 MB) --> to db (20,1 MB) --> save ~52,1% (~8s)

#### v0.4

- test.evl (42 MB) --> to db (19,1 MB) --> save ~52,6% (~8s)

#### v0.3.x

- test.evl (42 MB) --> to db (19,1 MB) --> save ~52,6% (~1m 42s)

#### v0.2

- test.evl (42 MB) --> to db (25,1 MB) --> save ~40,2% (~2m 20s)

#### V0.1

- test.evl (42 MB) --> test.txt (30,8 MB, 116 615 lines) --> to db (26,1 MB) --> save ~37,8% (~22s + ~2m 45s)
