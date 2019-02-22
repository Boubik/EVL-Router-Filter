# **EVL-Router-filter**

    Is for filtering and storing evl logs from routers.

## **Setup**

    1) Setup your server with php and mysql/marinadb.
    2) look in config.php
    3) open index.php
    4) put your .evl files in folder "files"
    5) click on "Import to DB" (It may take while)

## **Changelog**

[changelog.md](changelog.md)

## **Testing** (I5-5257U 2,7Ghz  8GB ram)

    v0.2
        test.evl (42 MB) --> to db (25,1 MB) --> save ~40,2%
                                   (~2m 20s)

    V0.1
        test.evl (42 MB) --> test.txt (30,8 MB, 116 615 řádků) --> to db (26,1 MB) --> save ~37,8%
                                    (~22s)                       (~2m 45s)