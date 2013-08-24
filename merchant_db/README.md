Athena Merchant Database
=======

Unpack items before using :)



/src/map/vending.c

Function: vending_closevending

After
```C
clif_closevendingboard(&sd->bl, 0);
```
Add
```C
//vending to db [Sanasol]
if( SQL_ERROR == Sql_Query(mmysql_handle,"delete from `vending` where `char_id`='%d'", sd->status.char_id) )
Sql_ShowDebug(mmysql_handle);
//vending to db [Sanasol]
```

Function: vending_openvending

After
```C
clif_openvending(sd,sd->bl.id,sd->vending);
```
Add
```C
    //vending to db [Sanasol]
    for( j = 0; j < count; j++ )
    {
        int index = sd->vending[j].index;
        struct item_data* data = itemdb_search(sd->status.cart[index].nameid);
        int nameid = ( data->view_id > 0 ) ? data->view_id : sd->status.cart[index].nameid;
        int amount = sd->vending[j].amount;
        int price = cap_value(sd->vending[j].value, 0, (unsigned int)battle_config.vending_max_value);
        
        if( SQL_ERROR == Sql_Query(mmysql_handle,"INSERT INTO `vending` (`char_id`,`name`,`index`,`nameid`,`amount`,`price`,`refine`,`card0`,`card1`,`card2`,`card3`) VALUES (%d, '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d')", sd->status.char_id, message, j, nameid, amount, price, sd->status.cart[index].refine, sd->status.cart[index].card[0], sd->status.cart[index].card[1], sd->status.cart[index].card[2], sd->status.cart[index].card[3]) )
        Sql_ShowDebug(mmysql_handle);
    }
    //vending to db [Sanasol]
```

To database import table
```SQL
CREATE TABLE IF NOT EXISTS `vending` (
  `char_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `index` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `nameid` int(11) unsigned NOT NULL DEFAULT '0',
  `amount` int(11) unsigned NOT NULL DEFAULT '0',
  `price` bigint(20) unsigned NOT NULL DEFAULT '0',
  `refine` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `card0` smallint(11) NOT NULL DEFAULT '0',
  `card1` smallint(11) NOT NULL DEFAULT '0',
  `card2` smallint(11) NOT NULL DEFAULT '0',
  `card3` smallint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`char_id`,`index`),
  KEY `char_id` (`char_id`),
  KEY `nameid` (`nameid`)
) ENGINE=MyISAM;
```