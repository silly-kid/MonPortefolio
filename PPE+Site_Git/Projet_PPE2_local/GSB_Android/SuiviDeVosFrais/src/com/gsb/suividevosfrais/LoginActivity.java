package com.gsb.suividevosfrais;

/**
 * Classe d'activit� pour l'autentification (image avec : lit ): "activity_login.xml"
 * @author Flora Carriere
 *
 */

import android.os.Bundle; //public final class Bundle
import android.app.Activity; //public class Activity
import android.util.Log;
import android.widget.DatePicker.OnDateChangedListener; //public class DatePicker extends FrameLayout
import android.content.Intent; // public class Intent extends Object implements Parcelable, Cloneable
import android.view.Menu; //public interface Menu
import android.view.View; //public class View extends Object
import android.widget.Button; //public class Button extends TextView
import android.widget.DatePicker; //public class DatePicker extends FrameLayout
import android.widget.EditText; //public class EditText extends TextView
import android.widget.ImageView; //public class ImageView extends View
import android.widget.Toast;

/**
 * Classe d'activit� pour les frais kilometriques (image avec : voiture ): "activity_km.xml"
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
 * findViewById (): trouve la vue grace � l'id pass� en paramettre
 *
 * DatePicker : The DatePicker displays a calendar allowing the user to select a single date or a date range.
 *
 * getMenuInflater (): Returns a MenuInflater with this context.
 *
 * inflater () : This constructor creates an inflater that expects a header from the input stream. D�s�rialiser
 *
 * containsKey : method is used to check if this map contains a mapping for the specified key. retourne vrai ou faux.
 *
 * setOnClickListener, OnClickListener : pour g�rer l'appui sur une touche.
 *
 * Serializer, serialize : qui permet de rendre un objet persistant pour stockage ou �change et vice versa.
 * Cet objet est mis sous une forme sous laquelle il pourra �tre reconstitu� � l'identique.
 * Ainsi il pourra �tre stock� sur un disque dur ou transmis au travers d'un r�seau
 *
 * onClick : Appell� quand une vue est cliqu�.
 *
 * Math.max : renvoie le plus grand nombre d'une s�rie de 0 ou plusieurs nombres.
 *
 * OnDateChangedListener : Appeller pour un changement de date
 *
 * put : ??
 *
 * Intent : permettent d�envoyer et recevoir des messages pour d�clencher une action, dans un composant d�une m�me application .
 *
 * @Override : est utilis� pour d�finir une m�thode qui est h�rit�e de la classe parente.
 */

public class LoginActivity extends Activity { // extends -> �tendre une classe implements -> c'est la m�me chose mais pour une interface


    @Override //est utilis� pour d�finir une m�thode qui est h�rit�e de la classe parente.
    protected void onCreate(Bundle savedInstanceState) { //d�s�rialisation � la cr�ation de l'activit�
        super.onCreate(savedInstanceState); //r�cup�re ou cr�e une nouvelle activit�e
        setContentView(R.layout.login); //permet de d�s�rialiser un fichier XML d'affichage dans une classe java, � savoir une Activity, r�cup�re la vue

        cmdLogin_clic();
    }

    @Override//est utilis� pour d�finir une m�thode qui est h�rit�e de la classe parente.
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present. ???
        getMenuInflater().inflate(R.menu.login, menu);
        return true;
    }

    private void cmdLogin_clic() {
        ((Button)findViewById(R.id.bLogin)).setOnClickListener(new Button.OnClickListener() { //click sur cmdKmPlus
            public void onClick(View v) {

                // cr�ation de l'objet d'acc�s ? distance avec ref?finition ? la vol�e de la m�thode onPostExecute
                AccesHTTP accesDonnees = new AccesHTTP() {
                    @Override
                    protected void onPostExecute(Long result) {
                        // ret contient l'information r�cup�r�e
                        Log.d("retour du serveur", this.ret.toString());

                        String goodLogin = this.ret.toString();
                        if (goodLogin!= null && !goodLogin.isEmpty()) {
                            retourActivityPrincipale();
                        }else {
                            Toast.makeText(LoginActivity.this, "login ou mot de passe incorrect", Toast.LENGTH_LONG).show();
                            return;
                        }
                    }
                };

                EditText LoginText = (EditText)findViewById(R.id.etUsername);
                EditText MdpText = (EditText)findViewById(R.id.etPassword);

                String login=LoginText.getText().toString();
                String mdp=LoginText.getText().toString();
                if(login.equals("") || mdp.equals("") ){
                    Toast.makeText(LoginActivity.this, "login ou mot de passe vide", Toast.LENGTH_LONG).show();
                    return;
                }

                accesDonnees.addParam("op", "login");
                accesDonnees.addParam("login",login );
                accesDonnees.addParam("mdp",mdp );

                //envoie
                accesDonnees.execute("http://10.0.2.2//Projet_PPE2_local/GSB_Android/SuiviDeVosFrais/SuivieFraisBdd/connection_bdd.php");
            }
        }) ;
    }
    /**
     * Retour � l'activit� principale (le menu)
     */
    private void retourActivityPrincipale() {
        Intent intent = new Intent(LoginActivity.this, MainActivity.class) ; //changement d'activit�
        startActivity(intent) ;
    }
}

