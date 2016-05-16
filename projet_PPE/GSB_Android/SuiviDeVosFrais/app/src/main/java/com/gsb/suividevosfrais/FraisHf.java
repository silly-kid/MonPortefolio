package com.gsb.suividevosfrais;

import java.io.Serializable;

/**
 * Classe métier contenant la description d'un frais hors forfait
 * Classe FraisHf privé : montant, motif, jour
 * Image avec le point d'interogation
 */
public class FraisHf  implements Serializable {

	private Integer montant ;
	private String motif ;
	private Integer jour ;
	
	public FraisHf(Integer montant, String motif, Integer jour) {
		this.montant = montant ;
		this.motif = motif ;
		this.jour = jour ;
	}

	public Integer getMontant() {
		return montant;
	} //récupère la propriété privée montant

	public String getMotif() {
		return motif;
	} //récupère la propriété privée motif

	public Integer getJour() {
		return jour;
	} //récupère la propriété privée jour

}
