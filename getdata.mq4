int deinit() {

   return(0);
}
int init()
{
   EventSetMillisecondTimer(500);
   return(0);
}    

void OnTimer()
{
//get from php
   string a ="";
	int    res; 
   char   data[]; 
   char returndata[];
   ArrayResize(data,StringToCharArray(a,data,0,WHOLE_ARRAY,CP_UTF8)-1);
   res=WebRequest("GET","http://localhost/xzy.php",NULL,5000,data,returndata,a);
   Print("Got comamnd:", CharArrayToString(returndata));
}

void OnTick()
{
// send to php
	string a = TimeToStr(TimeGMT()) + "," + Bid + "," + Ask + "," + Open[0];
	//make_request(1.2);
	int    res; 
   char   data[];  // Data array to send POST requests
   char returndata[];
   ArrayResize(data,StringToCharArray(a,data,0,WHOLE_ARRAY,CP_UTF8)-1);
   Print(a);
   uint start=GetTickCount();
   //Print("Sent Time:", start );
   res=WebRequest("POST","http://localhost/abc.php",NULL,5000,data,returndata,a);
   uint end = GetTickCount();
  // Print("Received Time:", end);
   Print(CharArrayToString(returndata));
  // Print("Delay:", end-start); 
   
   
   
   if(res!=200)
   {
     Print("Error #"+(string)res+", LastError="+(string)GetLastError());
     return(false);
   }
	
}


