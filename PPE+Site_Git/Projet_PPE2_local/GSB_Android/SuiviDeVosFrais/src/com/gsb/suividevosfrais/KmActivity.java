package com.gsb.suividevosfrais;

import android.os.Bundle; //public final class Bundle
import android.app.Activity; //public class Activity
import android.widget.DatePicker.OnDateChangedListener; //public class DatePicker extends FrameLayout
import android.content.Intent; // public class Intent extends Object implements Parcelable, Cloneable
import android.view.Menu; //public interface Menu
import android.view.View; //public class View extends Object
import android.widget.Button; //public class Button extends TextView 
import android.widget.DatePicker; //public class DatePicker extends FrameLayout
import android.widget.EditText; //public class EditText extends TextView
import android.widget.ImageView; //public class ImageView extends View

/**
 * Classe d'activité pour les frais kilometriques (image avec : voiture ): "activity_km.xml"
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
  
public class KmActivity extends Activity { // extends -> étendre une classe implements -> c'est la même chose mais pour une interface 

	// informations affichées dans l'activité : propriétées privées
	private Integer annee ; //l'année
	private Integer mois ; //le mois
	private Integer qte ; //la quantité
	
	@Override //est utilisé pour définir une méthode qui est héritée de la classe parente.
	protected void onCreate(Bundle savedInstanceState) { //désérialisation à la création de l'activité 
		super.onCreate(savedInstanceState); //récupère ou crée une nouvelle activitée
		setContentView(R.layout.activity_km); //permet de désérialiser un fichier XML d'affichage dans une classe java, à savoir une Activity, récupère la vue
		// modification de l'affichage du DatePicker
		Global.changeAfficheDate((DatePicker) findViewById(R.id.datKm)) ;
		// valorisation des propriétés
		valoriseProprietes() ;
        // chargement des méthodes évènementielles
		imgReturn_clic() ; //retour au menu principal
		cmdValider_clic() ; //valider les informations
		cmdPlus_clic() ; //augmenter la quantité
		cmdMoins_clic() ; //diminuer la quantité
		dat_clic() ; //mise a jour de l'affichage de la qte enfonction de la date 
	}

	@Override//est utilisé pour définir une méthode qui est héritée de la classe parente.
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present. ???
		getMenuInflater().inflate(R.menu.frais_km, menu);
		return true;
	}

	/**
	 * Valorisation des propriétés avec les informations affichées
	 */
	private void valoriseProprietes() {
		annee = ((DatePicker)findViewById(R.id.datKm)).getYear() ; //récupération de l'année
		mois = ((DatePicker)findViewById(R.id.datKm)).getMonth() + 1 ; //récupération du mois +1 parce que ca commence à 0
		// récupération de la qte correspondant au mois actuel
		qte = 0 ;
		Integer key = annee*100+mois ;
		if (Global.listFraisMois.containsKey(key)) {
			qte = Global.listFraisMois.get(key).getKm() ;
		}
		((EditText)findViewById(R.id.txtKm)).setText(qte.toString()) ; //valorise info , changement du txtkm
	}
	
	/**
	 * Sur la selection de l'image : retour au menu principal
	 */
    private void imgReturn_clic() {
    	((ImageView)findViewById(R.id.imgKmReturn)).setOnClickListener(new ImageView.OnClickListener() { //click sur imgKmReturn
    		public void onClick(View v) {
    			retourActivityPrincipale() ; //re tour à l'activité principale   		
    		}
    	}) ;
    }

    /**
     * Sur le clic du bouton valider : sérialisation
     */
    private void cmdValider_clic() {
    	((Button)findViewById(R.id.cmdKmValider)).setOnClickListener(new Button.OnClickListener() { //click sur cmdKmValider
    		public void onClick(View v) {
    			Serializer.serialize(Global.filename, Global.listFraisMois, KmActivity.this) ; //sérialisation
    			retourActivityPrincipale() ; //retour à l'activité principale   		
    		}
    	}) ;    	
    }
    
    /**
     * Sur le clic du bouton plus : ajout de 10 dans la quantité
     */
    private void cmdPlus_clic() {
    	((Button)findViewById(R.id.cmdKmPlus)).setOnClickListener(new Button.OnClickListener() { //click sur cmdKmPlus
    		public void onClick(View v) {
    			qte+=10 ; //ajout de 10 en 10 
    			enregNewQte() ;//Enregistrement dans la zone de texte et dans la liste de la nouvelle qte, à la date choisie
    		}
    	}) ;    	
    }
    
    /**
     * Sur le clic du bouton moins : enlève 10 dans la quantité si c'est possible
     */
    private void cmdMoins_clic() {
    	((Button)findViewById(R.id.cmdKmMoins)).setOnClickListener(new Button.OnClickListener() {
    		public void onClick(View v) {
   				qte = Math.max(0, qte-10) ; // suppression de 10 si possible
    			enregNewQte() ; //Enregistrement dans la zone de texte et dans la liste de la nouvelle qte, à la date choisie
     		}
    	}) ;    	
    }
    
    /**
     * Sur le changement de date : mise à jour de l'affichage de la qte
     */
    private void dat_clic() {   	
    	final DatePicker uneDate = (DatePicker)findViewById(R.id.datKm) ; //recuération de la vue 
    	uneDate.init(uneDate.getYear(), uneDate.getMonth(), uneDate.getDayOfMonth(), new OnDateChangedListener(){
			@Override
			public void onDateChanged(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
				valoriseProprietes() ; //mise a jour de l'affichage de la qte en fonction de la date 				
			}
    	});       	
    }

	/**
	 * Enregistrement dans la zone de texte et dans la liste de la nouvelle qte, à la date choisie
	 */
	private void enregNewQte() {
		// enregistrement dans la zone de texte
		((EditText)findViewById(R.id.txtKm)).setText(qte.toString()) ;
		// enregistrement dans la liste
		Integer key = annee*100+mois ;
		if (!Global.listFraisMois.containsKey(key)) { //si la clé n'est pas ok 
			// creation du mois et de l'annee s'ils n'existent pas déjà
			Global.listFraisMois.put(key, new FraisMois(annee, mois)) ;
		}
		Global.listFraisMois.get(key).setKm(qte) ; //changement de la quantité en fonction de la clé		
	}

	/**
	 * Retour à l'activité principale (le menu)
	 */
	private void retourActivityPrincipale() {
		Intent intent = new Intent(KmActivity.this, MainActivity.class) ; //changement d'activité
		startActivity(intent) ;   					
	}
}
