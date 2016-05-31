package com.gsb.suividevosfrais;

import java.io.Serializable; //permet de rendre un objet ou un graphe d'objets de la JVM persistant pour stockage ou échange et vice versa. 

/**
 * Classe métier contenant la description d'un frais hors forfait
 * @author Flora Carriere
 *
 */
 
public class FraisHf  implements Serializable { // extends -> étendre une classe implements -> c'est la même chose mais pour une interface

	//propriétés privées :
	private Integer montant ; //le montant du FraisHf
	private String motif ; //le motif du FraisHf
	private Integer jour ; //le jour du FraisHf
	
	//Constructeur
	public FraisHf(Integer montant, String motif, Integer jour) {
		this.montant = montant ;
		this.motif = motif ;
		this.jour = jour ;
	}

	public Integer getMontant() { //recupère la prop privée montant
		return montant;
	}

	public String getMotif() { //recupère la prop privée motif
		return motif;
	}

	public Integer getJour() { //recupère la prop privée jour
		return jour;
	}

}
