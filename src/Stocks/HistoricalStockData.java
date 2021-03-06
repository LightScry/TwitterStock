package Stocks;

import java.text.ParseException;
import java.text.SimpleDateFormat;

/**
 * Created by Stefan Anders Mellem on 2/18/14.
 */
public class HistoricalStockData {
    public String Symbol;
    public String Date;
    public float Open;
    public float High;
    public float Low;
    public float Close;
    public long Volume;
    public float Adj_Close;

    public long getDateAsLong(){
        SimpleDateFormat formatter = new SimpleDateFormat("yyyy-MM-dd");
        try{
            return formatter.parse(Date).getTime();
        }
        catch (ParseException pe){
            pe.printStackTrace();
            System.err.println("[ERROR] failed to parse stock timestamp");
            return -1;
        }
    }

    public String toString(){
        return id() +" "+Symbol+" "+Date+" "+High+" "+Low+" "+Open+" "+Close+" "+Volume+" "+Adj_Close;
    }

    public String id() {
	    return Symbol + Date;
    }
}
