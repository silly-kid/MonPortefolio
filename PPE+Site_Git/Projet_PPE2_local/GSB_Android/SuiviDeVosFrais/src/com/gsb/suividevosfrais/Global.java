package com.gsb.suividevosfrais;

import java.io.File;
import java.lang.reflect.Field;
import java.util.ArrayList;
import java.util.Hashtable;

import android.content.Context;
import android.content.Intent;
import android.os.Environment;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageView;

/**
 * Classe globale a toute l'application
 * @author Flora Carriere
 *
 */
 
 /**
  * INFOS :
  *
  * Hashtable : tableaux 
  *
  * field :  is a variable inside a class
  *
  * getClass :
  *
  * getDeclaredFields ():  returns an array of Field objects including public, 
  * protected, default (package) access, and private fields, but excludes inherited fields.
  *
  * equals (): permet de tester l'égalité de deux objets d'un point de vue sémantique.
  *
  * setAccessible : This method has a boolen parameter flag, which indicates the new accessibility of any fields or methods.
  *
  * setVisibility : hide or show views.
  *
  * SecurityException : Thrown when a security manager check fails.
  *
  * IllegalArgumentException : Thrown to indicate that a method has been passed an illegal or inappropriate argument.
  *
  * IllegalAccessException : An IllegalAccessException is thrown when an application tries to reflectively create an instance.
  *
  */
  
public abstract class Global {

	// tableau d'informations mémorisées
	public static Hashtable<Integer, FraisMois> listFraisMois = new Hashtable<Integer, FraisMois>() ;

	// fichier contenant les informations sérialisées
	public static final String filename = new String("save.fic") ;

	/**
	 * Modification de l'affichage de la date (juste le mois et l'année, sans le jour)
	 */
	public static void changeAfficheDate(DatePicker datePicker) {
		try {
		    Field f[] = datePicker.getClass().getDeclaredFields();
		    for (Field field : f) {
		        if (field.getName().equals("mDaySpinner")) {
		            field.setAccessible(true);
		            Object dayPicker = new Object();
		            dayPicker = field.get(datePicker);
		            ((View) dayPicker).setVisibility(View.GONE);
		        }
		    }
		} catch (SecurityException e) { //en cas d'erreur 
		    Log.d("ERROR", e.getMessage());
		} catch (IllegalArgumentException e) {
		    Log.d("ERROR", e.getMessage());
		} catch (IllegalAccessException e) {
		    Log.d("ERROR", e.getMessage());
		}	
	}
	
}
