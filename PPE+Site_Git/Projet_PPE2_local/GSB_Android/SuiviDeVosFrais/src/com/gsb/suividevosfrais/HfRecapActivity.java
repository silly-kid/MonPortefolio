package com.gsb.suividevosfrais;

import java.util.ArrayList;
import com.gsb.suividevosfrais.FraisHfAdapter.SupprClicListener;
import android.os.Bundle; //public final class Bundle
import android.app.Activity; //public class Activity
import android.widget.DatePicker.OnDateChangedListener;  //public class DatePicker extends FrameLayout
import android.content.Intent; // public class Intent extends Object implements Parcelable, Cloneable
import android.util.Log; //public final class Log extends Object 
import android.view.Menu;//public interface Menu
import android.view.View;//public class View extends Object
import android.widget.AdapterView;//public abstract class AdapterView extends ViewGroup
import android.widget.AdapterView.OnItemClickListener;//public static interface AdapterView.OnItemClickListener 
import android.widget.DatePicker;//public class DatePicker extends FrameLayout
import android.widget.ImageView;//public class ImageView extends View
import android.widget.ListView;//public class ListView extends AbsListView 

/**
 * Classe Activité pour le récapitulatif des frais hors forfait
 * (image avec :point interogation entouré ): "activity_hf_recap.xml"
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
  
public class HfRecapActivity extends Activity { // extends -> étendre une classe implements -> c'est la même chose mais pour une interface 

	@Override 
	protected void onCreate(Bundle savedInstanceState) { //désérialisation à la création de l'activité
		super.onCreate(savedInstanceState); //récupère ou crée une nouvelle activitée
		setContentView(R.layout.activity_hf_recap); //permet de désérialiser un fichier XML d'affichage dans une classe java, à savoir une Activity, récupère la vue
		// modification de l'affichage du DatePicker
		Global.changeAfficheDate((DatePicker) findViewById(R.id.datHfRecap)) ;
		// valorisation des propriétés
		afficheListe() ;
        // chargement des méthodes évènementielles
		imgReturn_clic() ; //retour au menu principal
		dat_clic() ; //mise a jour de l'affichage du FraisHf enfonction de la date  
	}

	@Override 
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.hf_recap, menu);
		return true;
	}

	/**
	 * Affiche la liste des frais hors forfaits de la date sélectionnée : a revoir 
	 */
	private void afficheListe() {
		Integer annee = ((DatePicker)findViewById(R.id.datHfRecap)).getYear() ; //récupération de l'année
		Integer mois = ((DatePicker)findViewById(R.id.datHfRecap)).getMonth() + 1 ; //récupération du mois +1 parce que ca commence à 0
		// récupération des frais HF pour cette date
		Integer key = annee*100 + mois ;
		ArrayList<FraisHf> liste = null ;
		if (Global.listFraisMois.containsKey(key)) { //si la clé est ok 
			liste = Global.listFraisMois.get(key).getLesFraisHf() ; //récupération des FraisHf
		}else{
			liste = new ArrayList<FraisHf>() ; //sinon création
			// insertion dans la listview
		}
		ListView listView = (ListView)findViewById(R.id.lstHfRecap) ; //recupération de la vue 
		FraisHfAdapter adapter = new FraisHfAdapter(HfRecapActivity.this, liste, key, new SupprClicListener(){
			public void onSupprClick(int index) {
				Integer annee = ((DatePicker)findViewById(R.id.datHfRecap)).getYear() ;
				Integer mois = ((DatePicker)findViewById(R.id.datHfRecap)).getMonth() + 1 ;
				Integer key = annee*100 + mois ;
				Global.listFraisMois.get(key).supprFraisHf(index);
				Serializer.serialize(Global.filename, Global.listFraisMois, HfRecapActivity.this);
				afficheListe();
			}
		}) ;
		listView.setAdapter(adapter) ;
	}
	
	/**
	 * Sur la selection de l'image : retour au menu principal
	 */
    private void imgReturn_clic() {
    	((ImageView)findViewById(R.id.imgHfRecapReturn)).setOnClickListener(new ImageView.OnClickListener() { //click sur imgHfRecapReturn
    		public void onClick(View v) {
    			retourActivityPrincipale() ;    		
    		}
    	}) ;
    }

    /**
     * Sur le changement de date : mise à jour de l'affichage de la qte
     */
    private void dat_clic() {   	
    	final DatePicker uneDate = (DatePicker)findViewById(R.id.datHfRecap) ; //recuération de la vue 
    	uneDate.init(uneDate.getYear(), uneDate.getMonth(), uneDate.getDayOfMonth(), new OnDateChangedListener(){ 
			@Override
			public void onDateChanged(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
				afficheListe() ; //mise a jour de l'affichage de la qte en fonction de la date 				
			}
    	});       	
    }
    
    

	/**
	 * Retour à l'activité principale (le menu)
	 */
	private void retourActivityPrincipale() {
		Intent intent = new Intent(HfRecapActivity.this, MainActivity.class) ; //changement d'activité
		startActivity(intent) ;   					
	}
}
