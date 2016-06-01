package com.gsb.suividevosfrais;

import java.io.IOException;
import java.io.OutputStream;
import java.util.Hashtable;

import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;

import android.os.Bundle;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.Button;

import android.database.sqlite.SQLiteDatabase;
//import android.support.v7.app.ActionBarActivity
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.DatePicker;
import android.widget.LinearLayout;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.ScrollView;
import android.widget.Toast;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.ImageView;
import android.graphics.Color;
import android.database.Cursor;
import android.util.Log ;
import java.util.Date;
import java.text.SimpleDateFormat ;
import java.text.ParseException;
import org.json.JSONArray ;
import org.json.JSONException ;

public class MainActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        // r?cup?ration des informations s?rialis?es
        recupSerialize() ;

        // chargement des m?thodes ?v?nementielles
        cmdMenu_clic(((Button)findViewById(R.id.cmdKm)), KmActivity.class) ; //Activit? Frais forfait km
        cmdMenu_clic(((Button)findViewById(R.id.cmdRepas)), RepActivity.class); //Activit? Frais forfait repas
        cmdMenu_clic(((Button)findViewById(R.id.cmdNuitee)), NuiteeActivity.class); //Activit? Frais forfait nuit
        cmdMenu_clic(((Button)findViewById(R.id.cmdEtape)), EtapeActivity.class); //Activit? Frais forfait etape
        cmdMenu_clic(((Button)findViewById(R.id.cmdHf)), HfActivity.class) ; //Activit? Frais Hforfait 
        cmdMenu_clic(((Button)findViewById(R.id.cmdHfRecap)), HfRecapActivity.class) ; //Activit? Frais Hforfait recapitulatif
        cmdTransfert_clic() ;
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }
    
    /**
     * R?cup?re la s?rialisation si elle existe
     */
    private void recupSerialize() {
    	Global.listFraisMois = (Hashtable<Integer, FraisMois>) Serializer.deSerialize(Global.filename, MainActivity.this) ;
    	// si rien n'a ?t? r?cup?r?, il faut cr?er la liste
    	if (Global.listFraisMois==null) {
    		Global.listFraisMois = new Hashtable<Integer, FraisMois>() ;
    	}
    }

    /**
     * Sur la s?lection d'un bouton dans l'activit? principale ouverture de l'activit? correspondante
     */
    private void cmdMenu_clic(Button button, final Class classe) {
    	button.setOnClickListener(new Button.OnClickListener() {
    		public void onClick(View v) {
    			// ouvre l'activit? 
    			Intent intent = new Intent(MainActivity.this, classe) ;
    			startActivity(intent) ;  			
    		}
    	}) ;
    }
    
    /**
     * Cas particulier du bouton pour le transfert d'informations vers le serveur
     */
    private void cmdTransfert_clic() {
    	((Button)findViewById(R.id.cmdTransfert)).setOnClickListener(new Button.OnClickListener() {
    		public void onClick(View v) {
    			// envoi les informations s?rialis?es vers le serveur
    			// en construction

                //recupLastProfilDistant();
                enregBdDistante();
    		}
    	}) ;    	
    }
	
	//test tache 3

    /**
     * R?cup?ration de la derni?re mesure enregistr?e dans la base distante
    */
    private void recupLastProfilDistant() {
        // cr?ation de l'objet d'acc?s ? distance avec ref?finition ? la vol?e de la m?thode onPostExecute
        AccesHTTP accesDonnees = new AccesHTTP(){
            @Override
            protected void onPostExecute(Long result) {
                Integer km ;
                Integer etape ;
                Integer nuitee ;
                Integer repas ;
                try {
                    // ret contient l'information r?cup?r?e
                    JSONArray tabJson = new JSONArray(this.ret);
                    // test si on a r?cup?r? quelque chose
                    if (tabJson.length()!=0) {
                        // dans le cas pr?sent, un seul tuple r?cup?r?
                        int i = 0 ;
                        km = Integer.parseInt(tabJson.getJSONObject(i).getString("km")) ;
                        etape = Integer.parseInt(tabJson.getJSONObject(i).getString("etape")) ;
                        nuitee = Integer.parseInt(tabJson.getJSONObject(i).getString("nuitee")) ;
                        repas = Integer.parseInt(tabJson.getJSONObject(i).getString("repas")) ;
                        // valorisation des objets graphiques avec les informations r?cup?r?es
                        ((EditText) findViewById(R.id.txtKm)).setText(km.toString());
                        ((EditText) findViewById(R.id.txtEtape)).setText(etape.toString());
                        ((EditText) findViewById(R.id.txtNuitee)).setText(nuitee.toString());
                        ((EditText) findViewById(R.id.txtRep)).setText(repas.toString());

                    }
                }catch (JSONException e){
                    Log.d("log","pb decodage JSON "+e.toString());
                }
            }
        };
        accesDonnees.addParam("op", "recup");
        accesDonnees.execute("http://localhost/PPE2_test/SuiviDeVosFrais/SuivieFraisBdd/serveurcoach.php");
    }

    /**
     * Enregistrement du profil dans la base de donn?es distante
    */
    private void enregBdDistante() {
        // cr?ation de l'objet d'acc?s ? distance avec ref?finition ? la vol?e de la m?thode onPostExecute
        AccesHTTP accesDonnees = new AccesHTTP(){
            @Override
            protected void onPostExecute(Long result) {
                // ret contient l'information r?cup?r?e
                Log.d("retour du serveur", this.ret.toString()) ;
            }
        };
        /*Integer annee;
        Integer mois;
        annee = ((DatePicker) findViewById(R.id.datEtape)).getYear();
        mois = ((DatePicker) findViewById(R.id.datEtape)).getMonth() + 1;
        Integer key = annee*100+mois;
        // ajout des donn?es en param?tre
        accesDonnees.addParam("op", "enreg");
        accesDonnees.addParam("km",  Global.listFraisMois.get(key).getKm().toString());
        accesDonnees.addParam("etape",  Global.listFraisMois.get(key).getEtape().toString());
        accesDonnees.addParam("nuitee", Global.listFraisMois.get(key).getNuitee().toString());
        accesDonnees.addParam("repas", Global.listFraisMois.get(key).getRepas().toString());;//*/

        accesDonnees.addParam("op", "enreg");
        accesDonnees.addParam("km",  "100");
        accesDonnees.addParam("etape",  "ddddd");
        accesDonnees.addParam("nuitee", "www");
        accesDonnees.addParam("repas", "ssss");
        // envoi
        accesDonnees.execute("http://127.0.0.1/PPE2_test/SuiviDeVosFrais/SuivieFraisBdd/serveurcoach.php");


    }
}

