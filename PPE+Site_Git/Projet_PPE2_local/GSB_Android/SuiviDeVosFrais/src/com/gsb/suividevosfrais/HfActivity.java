package com.gsb.suividevosfrais;

import android.os.Bundle; //public final class Bundle
import android.app.Activity; //public class Activity
import android.content.Intent; // public class Intent extends Object implements Parcelable, Cloneable
import android.view.Menu; //public interface Menu
import android.view.View; //public class View extends Object
import android.widget.Button; //public class Button extends TextView 
import android.widget.DatePicker; //public class DatePicker extends FrameLayout
import android.widget.EditText; //public class EditText extends TextView
import android.widget.ImageView; //public class ImageView extends View

/**
 * Classe d'activité pour les frais hors forfait (image avec :point interogation ): "activity_hf.xml"
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
  
public class HfActivity extends Activity { // extends -> étendre une classe implements -> c'est la même chose mais pour une interface 

	@Override 
	protected void onCreate(Bundle savedInstanceState) { //désérialisation à la création de l'activité 
		super.onCreate(savedInstanceState); //récupère ou crée une nouvelle activitée
		setContentView(R.layout.activity_hf); //permet de désérialiser un fichier XML d'affichage dans une classe java, à savoir une Activity, récupère la vue
		// mise à 0 du montant
		((EditText)findViewById(R.id.txtHf)).setText("0") ;
        // chargement des méthodes évènementielles
		imgReturn_clic() ; //retour au menu principal
		cmdAjouter_clic() ; //ajout du FraisHf dans la liste + serialisation
	}

	@Override 
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present. ???
		getMenuInflater().inflate(R.menu.hf, menu);
		return true;
	}

	/**
	 * Sur la selection de l'image : retour au menu principal
	 */
    private void imgReturn_clic() {
    	((ImageView)findViewById(R.id.imgHfReturn)).setOnClickListener(new ImageView.OnClickListener() { //click sur imgHfReturn
    		public void onClick(View v) {
    			retourActivityPrincipale() ; //retour à l'activité principale   		
    		}
    	}) ;
    }

    /**
     * Sur le clic du bouton ajouter : enregistrement dans la liste et sérialisation
     */
    private void cmdAjouter_clic() {
    	((Button)findViewById(R.id.cmdHfAjouter)).setOnClickListener(new Button.OnClickListener() { //click sur cmdHfAjouter
    		public void onClick(View v) {
    			enregListe() ; //enregistrement dans la liste 
    			Serializer.serialize(Global.filename, Global.listFraisMois, HfActivity.this) ; //sérialisation
    			retourActivityPrincipale() ; //retour à l'activité principale  		
    		}
    	}) ;    	
    }
    
	/**
	 * Enregistrement dans la liste du nouveau frais hors forfait
	 */
	private void enregListe() {
		// récupération des informations saisies
		Integer annee = ((DatePicker)findViewById(R.id.datHf)).getYear() ; //reucpération de l'année
		Integer mois = ((DatePicker)findViewById(R.id.datHf)).getMonth() + 1 ; //reucpération du mois +1 parce uqe ca commence à 0
		Integer jour = ((DatePicker)findViewById(R.id.datHf)).getDayOfMonth() ; ////reucpération du jour
		Integer montant = Integer.parseInt(((EditText)findViewById(R.id.txtHf)).getText().toString()) ; //reucpération du montant
		String motif = ((EditText)findViewById(R.id.txtHfMotif)).getText().toString() ; //reucpération du motif
		// enregistrement dans la liste
		Integer key = annee*100+mois ;
		if (!Global.listFraisMois.containsKey(key)) { //si la clé ne match pas 
			// creation du mois et de l'annee s'ils n'existent pas déjà
			Global.listFraisMois.put(key, new FraisMois(annee, mois)) ;
		}
		Global.listFraisMois.get(key).addFraisHf(montant, motif, jour) ; //ajout du fraisHf dans la liste	
	}

	/**
	 * Retour à l'activité principale (le menu)
	 */
	private void retourActivityPrincipale() {
		Intent intent = new Intent(HfActivity.this, MainActivity.class) ; //changement d'activité
		startActivity(intent) ;   					
	}
}
