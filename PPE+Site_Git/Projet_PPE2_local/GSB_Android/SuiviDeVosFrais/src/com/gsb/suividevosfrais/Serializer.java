package com.gsb.suividevosfrais;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.io.OutputStreamWriter;
import java.io.StreamCorruptedException;

import android.content.Context;
import android.os.Environment;
import android.util.Log;

/**
 * Classe qui permet de sérialiser et désérialiser des objets
 * 
 *
 */
 
 /**
  * INFOS :
  *
  * serialize : qui permet de rendre un objet persistant pour stockage ou échange et vice versa. 
  * Cet objet est mis sous une forme sous laquelle il pourra être reconstitué à l'identique.
  * Ainsi il pourra être stocké sur un disque dur ou transmis au travers d'un réseau 
  *
  * FileOutputStream : An output stream that writes bytes to a file. 
  * If the output file exists, it can be replaced or appended to. 
  * If it does not exist, a new file will be created.
  *
  * context :
  *
  * ObjectOutputStream oos :
  *
  * try : 
  *
  * IOException :
  *
  * printStackTrace :
  *
  * FileNotFoundException :
  */
  
public abstract class Serializer {

	/**
	 * Sérialisation d'un objet
	 * @param filename
	 * @param object
	 */
	public static void serialize(String filename, Object object, Context context) {
		try {
			FileOutputStream file = context.openFileOutput(filename, Context.MODE_PRIVATE) ; //ouverture du fichier
			ObjectOutputStream oos;
			try {
				oos = new ObjectOutputStream(file);
				oos.writeObject(object) ; //ecrit
				oos.flush() ; //vide
				oos.close() ; //ferme
			} catch (IOException e) { //en cas d'erreur 
				// erreur de sérialisation
				e.printStackTrace();
			}
		} catch (FileNotFoundException e) {
			// fichier non trouvé
			e.printStackTrace();
		}
	}
	
	/**
	 * Désérialisation d'un objet
	 * @param filename
	 * @param context
	 * @return
	 */
	public static Object deSerialize(String filename, Context context) {
		try {
			FileInputStream file = context.openFileInput(filename) ; //ouverture du fichier
			ObjectInputStream ois;
			try {
				ois = new ObjectInputStream(file);
				try {
					Object object = ois.readObject() ; //lire
					ois.close() ; //ferme
					return object ;
				} catch (ClassNotFoundException e) { //en cas d'erreur
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			} catch (StreamCorruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		} catch (FileNotFoundException e) {
			// fichier non trouvé
			e.printStackTrace();
		}
		return null ;		
	}
	
}
