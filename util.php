<?php
function BD_init(){
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=m4banking;charset=utf8',"vhshunter","123789456");
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        return $dbh;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

$privateKey = <<<EOF
-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQClLIJjfqHIPYut03pEub6DMvAFv3TDPIO/k/qC3ROlK1Ng6U2t
bHFABCOgINDne/esVwNzRYAs5Jii1YsnK5nKvdR2GNRNRT2qPL5m18qjxwiIRwBf
ZEa83WSPCt9hMmA5J5PyxWaBu47+fKv+I9l9YygQSDTmXeTvZmTF7L5HFwIDAQAB
AoGBAJxFqTNjGsOt3xpdy/970RCmP8rgYiNZfLjj046+hZiujhtRgGmFAPz1LZOR
mLR6aFDInn4QEn3m5bah3R75NG3EGXR7205R0c1IWMq/uT9Wu+XtmmA5ECxETMEt
ESXJR9zF0n2USTH3R6uhkYqtVCZMoqtprhI/9/a+Tx+T3k/ZAkEA2yXbILCYMzWO
p5uyePROuqyLd4Fy7R03XwGfXUqrORIAqHRC6x2aS6MRx4XCt1F2/W4IRkILU2g4
lRZGY1aMowJBAMDzHVTph3GT2OdIs1pIhgXicbROmzLPWF10tEZqbv3R1cwU5q7H
COcILG7fwRQoQdjvHR/c+2jo3dllMsBQLv0CQQDOVYlI8RyMcqu7IbxbZ+NMnbK+
tVII8M42lKeAxhIKrOmTsctj5b5l4saVrlpUEc7P9K6zv/E7+c/0h0GEvHOzAkAK
ROYqvsMWqGfC53ukMnfvmD20+voHmkF5t9xgYwnFOIXIdtRQOQegRC8ZN49vIzVd
9lv2dixrSPmFuH0a/ymBAkEArB6hQXddvOIjyXbC8XdHDDef9Wh6i53fwVqBy+Lu
3PFinCKCM/WqarvlAfzyHnV+HVkhaD8BVDix+0b/TaYLNw==
-----END RSA PRIVATE KEY-----
EOF;

$publicKey = <<<EOF
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQClLIJjfqHIPYut03pEub6DMvAF
v3TDPIO/k/qC3ROlK1Ng6U2tbHFABCOgINDne/esVwNzRYAs5Jii1YsnK5nKvdR2
GNRNRT2qPL5m18qjxwiIRwBfZEa83WSPCt9hMmA5J5PyxWaBu47+fKv+I9l9YygQ
SDTmXeTvZmTF7L5HFwIDAQAB
-----END PUBLIC KEY-----
EOF;
?>