package com.gsb.suividevosfrais;

import android.app.Activity; //public class Activity
import android.os.Bundle; //public final class Bundle
import android.view.Menu; //public interface Menu
import android.widget.DatePicker.OnDateChangedListener; //public class DatePicker extends FrameLayout
import android.content.Intent; // public class Intent extends Object implements Parcelable, Cloneable
import android.view.View; // public class Intent extends Object implements Parcelable, Cloneable
import android.widget.Button; //public class Button extends TextView
import android.widget.DatePicker; //public class DatePicker extends FrameLayout
import android.widget.EditText; //public class EditText extends TextView
import android.widget.ImageView; //public class ImageView extends View

/**
 * Classe d'activité pour les frais repas (image avec : couvert ): "activity_rep.xml"
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
  
public class RepActivity extends Activity { // extends -> étendre une classe implements -> c'est la même chose mais pour une interface

	//informations affichées dans l'activité
	private Integer annee; //l'année
	private Integer mois; //le mois
	private Integer qte; //la quantité
	
	@Override //est utilisé pour définir une méthode qui est héritée de la classe parente. 
	
	protected void onCreate(Bundle savedInstanceState) { //désérialisation à la création de l'activité 
		super.onCreate(savedInstanceState); //récupère ou crée une nouvelle activitée
		setContentView(R.layout.activity_rep); //permet de désérialiser un fichier XML d'affichage dans une classe java, à savoir une Activity, récupère la vue
		//modification de l'affichage du DatePicker
		Global.changeAfficheDate((DatePicker) findViewById(R.id.datRep));
		//valorisation des propri�t�s
		valoriseProprietes();
		//chargement des méthodes évènementielles
		imgReturn_clic(); //retour au menu principal
		cmdValider_clic(); //valider les informations
		cmdPlus_clic(); //augmenter la quantité
		cmdMoins_clic(); //diminuer la quantité
		dat_clic(); //mise a jour de l'affichage de la qte enfonction de la date
	}
	
	@Override //est utilisé pour définir une méthode qui est héritée de la classe parente. 
	
	public boolean onCreateOptionsMenu(Menu menu){
		//Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.repas, menu);
		return true;
	}
	
	/**
	 * Valorisation des propriétés avec les informations affichées
	 */
	private void valoriseProprietes(){
		annee = ((DatePicker) findViewById(R.id.datRep)).getYear(); //récupération de l'année
		mois = ((DatePicker) findViewById(R.id.datRep)).getMonth() + 1; //récupération du mois +1 parce que ca commence à 0
		//récupération de la qte correspondant au mois actuel
		qte = 0;
		Integer key = annee*100+mois;
		if(Global.listFraisMois.containsKey(key)){ //si la clé est ok
			qte = Global.listFraisMois.get(key).getRepas(); //getRepas
		}
		((EditText)findViewById(R.id.txtRep)).setText(qte.toString()); //Valorise info , changement du textRep
	}
	
	/**
	 * Sur la selection de l'image : retour au menu principal
	 */
	private void imgReturn_clic(){
		((ImageView) findViewById(R.id.imgRepReturn)).setOnClickListener(new ImageView.OnClickListener(){ //click sur imgRepReturn
			public void onClick(View v){
				retourActivityPrincipale(); //retourne à l'activité principale
			}
		});
	}
	
	/**
	 * Sur le clic du bouton valider : sérialisation
	 */
	private void cmdValider_clic(){
		((Button) findViewById(R.id.cmdRepValider)).setOnClickListener(new Button.OnClickListener(){ //click sur cmdRepValider
			public void onClick(View v){
				Serializer.serialize(Global.filename, Global.listFraisMois, RepActivity.this); //serialisation
				retourActivityPrincipale(); //retourne à l'activité principale
			}
		});
	}
	
	/**
	 * Sur le clic du bouton plus : ajout de 1 dans la quantité
	 */
	private void cmdPlus_clic(){
		((Button)findViewById(R.id.cmdRepPlus)).setOnClickListener(new Button.OnClickListener(){ //click sur cmdRepPlus
			public void onClick(View v){
				qte+=1; //ajout de 1 dans la quantité
				enregNewQte(); //Enregistrement dans la zone de texte et dans la liste de la nouvelle qte, à la date choisie
			}
		});
	}
	/**
	 * Sur le clic du bouton moins : enlève 1 dans la quantité si possible
	 */
	private void cmdMoins_clic(){
		((Button)findViewById(R.id.cmdRepMoins)).setOnClickListener(new Button.OnClickListener(){
			public void onClick(View v){
				qte = Math.max(0,  qte-1); //enlève 1 dans la quantité si possible
				enregNewQte(); //Enregistrement dans la zone de texte et dans la liste de la nouvelle qte, à la date choisie
			}
		});
	}
	
	/**
	 * Sur le changement de date : mise a jour de l'affichage de la qte
	 */
	private void dat_clic(){
		final DatePicker uneDate = (DatePicker)findViewById(R.id.datRep); //recuération de la vue 
		uneDate.init(uneDate.getYear(), uneDate.getMonth(), uneDate.getDayOfMonth(), new OnDateChangedListener(){
			@Override
			public void onDateChanged(DatePicker view, int year, int monthOfYear, int dayOfMonth){
				valoriseProprietes(); //mise a jour de l'affichage de la qte en fonction de la date
			}
		});
	}
	
	/**
	 * Enregistrement dans la zone de texte et dans la liste de la nouvelle qte, à la date choisie
	 */
	private void enregNewQte(){
		//enregistrement dans la zone de texte
		((EditText)findViewById(R.id.txtRep)).setText(qte.toString());
		//enregistrement dans la liste
		Integer key = annee*100+mois;
		if(!Global.listFraisMois.containsKey(key)){ //si la clé n'est pas ok
			//création du mois et de l'année s'ils n'existent pas déjà
			Global.listFraisMois.put(key, new FraisMois(annee,mois));
		}
		Global.listFraisMois.get(key).setRepas(qte); //changement de la quantité en fonction de la clé
	}
	
	/**
	 * Retour a l'activité principale (le menu)
	 */
	private void retourActivityPrincipale(){
		Intent intent = new Intent(RepActivity.this,MainActivity.class); //changement d'activité
		startActivity(intent);
	}
}
