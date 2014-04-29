-	script	itemgiver	-1,{
	
	OnInit:
	OnWhisperGlobal:
		initnpctimer;
	end;
	
    OnTimer5000:
		set .items, query_sql("select id,item_id,amount,account_id from `itemgiver` where received = 0", .id, .item_id, .amount, .account_id);
		
		for( set .i,0; .i<.items ; set .i,.i+1 )
		{
			if(isloggedin(.account_id[.i]))
			{
				getitem .item_id[.i],.amount[.i],.account_id[.i];
				announce "get",0;
				query_sql("update `itemgiver` set received = 1 where id = "+.id[.i]);
			}
		}
		stopnpctimer;
		initnpctimer;
	end;
}