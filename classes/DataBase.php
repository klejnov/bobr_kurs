<?php
/**
 * Connection MySQL
 */

class DataBase
{
    private $link;

    /**
     * Connection constructor.
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * @return $this
     */
    private function connect()
    {
        $config = require_once 'admin/config.php';
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
        $this->link = new PDO($dsn, $config['username'], $config['password']);
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $this;
    }

    /**
     * @param $sql
     *
     * @return mixed
     */
    public function execute($sql)
    {
        $sth = $this->link->prepare($sql);
        return $sth->execute();
    }

    /**
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->link->lastInsertId();
    }

    /**
     * @param $sql
     *
     * @return array
     */
    public function query($sql)
    {
        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchALL(PDO::FETCH_ASSOC);
        if ($result === false) {
            return [];
        }
        return $result;
    }

    /**
     * @param $start
     * @param $end
     *
     * @return array
     */
//    public function getCurrencyRatesWidget($start, $end)
//    {
//        $sth = $this->link->prepare(
//            "SELECT DATE_FORMAT(time, '%d.%m') AS time,
//                AVG(usd_buy) AS usd_buy,
//                AVG(usd_sell) AS usd_sell,
//                AVG(eur_buy) AS eur_buy,
//                AVG(eur_sell) AS eur_sell,
//                AVG(rub_buy) AS rub_buy,
//                AVG(rub_sell) AS rub_sell
//                FROM banks_kurs
//                WHERE time BETWEEN :sql_start AND :sql_end
//                AND usd_buy <> '0'
//                AND usd_sell <> '0'
//                AND eur_buy <> '0'
//                AND eur_sell <> '0'
//                AND rub_buy <> '0'
//                AND rub_sell <> '0'
//                GROUP BY DATE_FORMAT(time, '%Y-%m-%d')"
//        );
//
//        $sth->execute(array(
//            'sql_start' => $start,
//            'sql_end'   => $end,
//        ));
//
//        $result = $sth->fetchALL(PDO::FETCH_ASSOC);
//
//        if ($result === false) {
//            return [];
//        }
//
//        return $result;
//    }
//
//    public function getBanksRatesTable()
//    {
//        $sth = $this->link->prepare(
//            "SELECT * FROM ((SELECT
//                    b.id,
//                    b.name,
//                    b.ico,
//                    b.url,
//                    b.latlng,
//                    b.address,
//                    b.status,
//                    bk.usd_buy,
//                    bk.usd_sell,
//                    bk.eur_buy,
//                    bk.eur_sell,
//                    bk.rub_buy,
//                    bk.rub_sell,
//                    bk.banks_id,
//                    DATE_FORMAT(bk.time, '%Y-%m-%d %H:%i') AS time
//                FROM banks_kurs AS bk
//                LEFT JOIN banks AS b ON b.id = bk.banks_id)
//                UNION ALL
//                (SELECT id,
//                name,
//                ico,
//                url,
//                latlng,
//                address,
//                status,
//                0,
//                0,
//                0,
//                0,
//                0,
//                0,
//                id,
//                '0000-00-00 00:00:00'
//                FROM banks WHERE status = 1)
//                ORDER BY time DESC
//                ) AS bk2 WHERE status = 1 AND name NOT LIKE '%Банк для тестирования%'
//                GROUP BY bk2.banks_id"
//        );
//
//        $sth->execute();
//
//        $result = $sth->fetchALL(PDO::FETCH_ASSOC);
//
//        if ($result === false) {
//            return [];
//        }
//
//        echo json_encode($result);
//    }

    /**
     * @param $id_bank
     * @param $currency
     * @param $start
     * @param $end
     *
     * @return array
     */
    public function getCurrencyRatesChart($id_bank, $currency, $start, $end)
    {

        if ($currency == 'usd') {
            $currency = 'usd_buy, usd_sell';
        } elseif ($currency == 'eur') {
            $currency = 'eur_buy, eur_sell';
        } elseif ($currency == 'rub') {
            $currency = 'rub_buy, rub_sell';
        } else {
            exit();
        }
        $sth = $this->link->prepare(
            "SELECT id, 
                DATE_FORMAT(time, '%d.%m.%Y %H:%i') AS time,
                $currency
                FROM banks_kurs
                WHERE banks_id = :sql_banks_id AND time BETWEEN :sql_start AND :sql_end
                ORDER BY DATE_FORMAT(time, '%Y-%m-%d %H:%i')"
        );

        $sth->execute(array(
            'sql_banks_id' => $id_bank,
            'sql_start'    => $start,
            'sql_end'      => $end,
        ));

        $result = $sth->fetchALL(PDO::FETCH_ASSOC);

        if ($result === false) {
            return [];
        }

        return $result;
    }

    /**
     * @param $dbName
     *
     * Backing up the database in the directory /../backup/
     */
    static function backup()
    {
        $config = include 'admin/config.php';
        $today = date("Y.m.d_H-i-s");
        $dir = __DIR__;
        shell_exec("mysqldump -u{$config['username']} -p{$config['password']} {$config['db_name']} > $dir/../backup/dump_$today.sql");
    }

}
