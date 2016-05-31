package com.gsb.suividevosfrais;

import java.io.IOException;
import java.io.OutputStream;
import java.util.Hashtable;

import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;

import android.os.Bundle; //public final class Bundle
import android.app.Activity; //public class Activity
import android.content.Context; 
import android.content.Intent;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.Button;

/**
 * Classe d'activité principale de l'application : "activity_main.xml" , "AndroidManifest.xml"
 * @author Flora Carriere
 *
 */
 
 /** 
  * INFOS :
  *	onCreate(Bundle savedInstanceState) : you will get the Bundle null when activity get starts firt time 
  * and it will get in use when activity orientation get changed ..	
  *  
  * Bundle : A resource bundle is a Java .properties file that contains locale-specific data
  *
  * setContentView : Set the activity content to an explicit view.  
  *
  * Global : Used in XmlElementDecl.scope() to signal that the declaration is in the global scope.
  *
  * findViewById (): trouve la vue grace à l'id passé en paramettre
  *
  * DatePicker : The DatePicker displays a calendar allowing the user to select a single date or a date range.
  *  
  * getMenuInflater (): Returns a MenuInflater with this context.
  *
  * inflater () : This constructor creates an inflater that expects a header from the input stream. Désérialiser
  *
  * containsKey : method is used to check if this map contains a mapping for the specified key. retourne vrai ou faux.
  *
  * setOnClickListener, OnClickListener : pour gérer l'appui sur une touche. 
  *
  * Serializer, serialize : qui permet de rendre un objet persistant pour stockage ou échange et vice versa. 
  * Cet objet est mis sous une forme sous laquelle il pourra être reconstitué à l'identique.
  * Ainsi il pourra être stocké sur un disque dur ou transmis au travers d'un réseau
  *
  * onClick : Appellé quand une vue est cliqué.
  *
  * Math.max : renvoie le plus grand nombre d'une série de 0 ou plusieurs nombres.
  *
  * OnDateChangedListener : Appeller pour un changement de date 
  *
  * put : ??
  *
  * Intent : permettent d’envoyer et recevoir des messages pour déclencher une action, dans un composant d’une même application .
  *
  * @Override : est utilisé pour définir une méthode qui est héritée de la classe parente.  
  */
  
public class MainActivity extends Activity { // extends -> étendre une classe implements -> c'est la même chose mais pour une interface

    @Override 	
    protected void onCreate(Bundle savedInstanceState) { //désérialisation à la création de l'activité 
        super.onCreate(savedInstanceState); //récupère ou crée une nouvelle activitée
        setContentView(R.layout.activity_main); //permet de désérialiser un fichier XML d'affichage dans une classe java, à savoir une Activity, récupère la vue
        // récupération des informations sérialisées
        recupSerialize() ;
        // chargement des méthodes évènementielles
        cmdMenu_clic(((Button)findViewById(R.id.cmdKm)), KmActivity.class) ; //Activité Frais forfait km
        cmdMenu_clic(((Button)findViewById(R.id.cmdRepas)), RepActivity.class); //Activité Frais forfait repas
        cmdMenu_clic(((Button)findViewById(R.id.cmdNuitee)), NuiteeActivity.class); //Activité Frais forfait nuit
        cmdMenu_clic(((Button)findViewById(R.id.cmdEtape)), EtapeActivity.class); //Activité Frais forfait etape
        cmdMenu_clic(((Button)findViewById(R.id.cmdHf)), HfActivity.class) ; //Activité Frais Hforfait 
        cmdMenu_clic(((Button)findViewById(R.id.cmdHfRecap)), HfRecapActivity.class) ; //Activité Frais Hforfait recapitulatif
        cmdTransfert_clic() ; //transfert d'informations vers le serveur
    }

    @Override 
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present. ???
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }
    
    /**
     * Récupére la sérialisation si elle existe
     */
    private void recupSerialize() {
    	Global.listFraisMois = (Hashtable<Integer, FraisMois>) Serializer.deSerialize(Global.filename, MainActivity.this) ; //serialisation
    	// si rien n'a été récupéré, il faut créer la liste
    	if (Global.listFraisMois==null) {
    		Global.listFraisMois = new Hashtable<Integer, FraisMois>() ; //création du tableau 
    	}
    }

    /**
     * Sur la sélection d'un bouton dans l'activité principale ouverture de l'activité correspondante
     */
    private void cmdMenu_clic(Button button, final Class classe) {
    	button.setOnClickListener(new Button.OnClickListener() {
    		public void onClick(View v) {
    			// ouvre l'activité 
    			Intent intent = new Intent(MainActivity.this, classe) ; //chargement de l'activité
    			startActivity(intent) ; //démarage de l'activité			
    		}
    	}) ;
    }
    
    /**
     * Cas particulier du bouton pour le transfert d'informations vers le serveur
     */
    private void cmdTransfert_clic() {
    	((Button)findViewById(R.id.cmdTransfert)).setOnClickListener(new Button.OnClickListener() { //click sur cmdTransfert
    		public void onClick(View v) {
    			// envoi les informations sérialisées vers le serveur
    			// en construction
    		}
    	}) ;    	
    }
}
