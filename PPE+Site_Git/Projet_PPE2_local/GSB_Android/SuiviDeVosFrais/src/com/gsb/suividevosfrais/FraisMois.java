package com.gsb.suividevosfrais;

import java.io.Serializable;
import java.util.ArrayList;

import android.util.Log;

/**
 * Classe métier contenant les informations des frais forfait d'un mois
 *
 */
 
 /**
  * INFOS :
  *
  * Log :
  *
  */
  
public class FraisMois implements Serializable { // extends -> étendre une classe implements -> c'est la même chose mais pour une interface

	private Integer mois ; // mois concerné
	private Integer annee ; // année concernée
	private Integer etape ; // nombre d'étapes du mois
	private Integer km ; // nombre de km du mois
	private Integer nuitee ; // nombre de nuitées du mois
	private Integer repas ; // nombre de repas du mois
	private ArrayList<FraisHf> lesFraisHf ; // liste des frais hors forfait du mois
	
	//Constructeur
	public FraisMois(Integer annee, Integer mois) {
		this.annee = annee ;
		this.mois = mois ;
		this.etape = 0 ;
		this.km = 0 ;
		this.nuitee = 0 ;
		this.repas = 0 ;
		lesFraisHf = new ArrayList<FraisHf>() ;
	}

	/**
	 * Ajout d'un frais hors forfait
	 * @param montant
	 * @param motif
	 */
	public void addFraisHf(Integer montant, String motif, Integer jour) {
		lesFraisHf.add(new FraisHf(montant, motif, jour)) ;
	}
	
	/**
	 * Suppression d'un frais hors forfait
	 * @param index
	 */
	public void supprFraisHf(Integer index) {
		lesFraisHf.remove(lesFraisHf.get(index)) ;
		Log.d("Pass", lesFraisHf.size() + "");
	}
	
	public Integer getMois() { //récupère le mois 
		return mois;
	}

	public void setMois(Integer mois) { //modifier le mois
		this.mois = mois;
	}

	public Integer getAnnee() { //récupère l'année
		return annee;
	}

	public void setAnnee(Integer annee) { //modifier l'année
		this.annee = annee;
	}

	public Integer getEtape() { //récupère les etapes
		return etape;
	}

	public void setEtape(Integer etape) { //modifier les etapes
		this.etape = etape;
	}

	public Integer getKm() { //récupère les km
		return km;
	}

	public void setKm(Integer km) { //modifier les km
		this.km = km;
	}

	public Integer getNuitee() { //récupère les nuits 
		return nuitee;
	}

	public void setNuitee(Integer nuitee) { //modifier les nuits
		this.nuitee = nuitee;
	}

	public Integer getRepas() { //récupère les repas
		return repas;
	}

	public void setRepas(Integer repas) { //modifier les repas
		this.repas = repas;
	}	
	
	public ArrayList<FraisHf> getLesFraisHf() { //récupère la liste des frais Hf
		return lesFraisHf ;
	}
	
}
