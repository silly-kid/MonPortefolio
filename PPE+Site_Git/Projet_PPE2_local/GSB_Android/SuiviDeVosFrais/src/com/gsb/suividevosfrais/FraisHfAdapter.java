package com.gsb.suividevosfrais;

import java.util.ArrayList;

import com.gsb.suividevosfrais.FraisHfAdapter.SupprClicListener;

import android.R.integer;
import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.BaseAdapter;

/**
 * Classe d'affichage du tableau de récapitulatif
 * @author Franck Noel
 *
 */
public class FraisHfAdapter extends BaseAdapter {

	ArrayList<FraisHf> lesFrais ; // liste des frais du mois
	LayoutInflater inflater ;
	Integer key ;  // annee et mois (clé dans la liste)
	Context context ; // contexte pour gérer la sérialisation
	SupprClicListener supprlistener; //gestion des clics
	
	/**
	 * Constructeur de l'adapter pour valoriser les propriétés
	 * @param context
	 * @param lesFrais
	 * @param key
	 * @param supprClicListener
	 */
	public FraisHfAdapter(Context context, ArrayList<FraisHf> lesFrais, Integer key, SupprClicListener supprClicListener) {
		inflater = LayoutInflater.from(context) ;
		this.lesFrais = lesFrais ;
		this.key = key ;
		this.context = context ;
		this.supprlistener = supprClicListener;
	}

	/**
	 * retourne le nombre d'éléments de la listview
	 */
	@Override
	public int getCount() {
		return lesFrais.size() ;
	}

	/**
	 * retourne l'item de la listview à un index précis
	 */
	@Override
	public Object getItem(int index) {
		return lesFrais.get(index) ;
	}

	/**
	 * retourne l'index de l'élément actuel
	 */
	@Override
	public long getItemId(int index) {
		return index;
	}

	/**
	 * structure contenant les éléments d'une ligne
	 */
	private class ViewHolder {
		TextView txtListJour ;
		TextView txtListMontant ;
		TextView txtListMotif ;
		ImageView imgSupprimerLigne;
	}
	
	/**
	 * Affichage dans la liste
	 */
	@Override
	public View getView(int index, View convertView, ViewGroup parent) {
		ViewHolder holder ;
		if (convertView == null) {
			holder = new ViewHolder() ;
			convertView = inflater.inflate(R.layout.layout_liste, null) ;
			holder.txtListJour = (TextView)convertView.findViewById(R.id.txtListJour) ;
			holder.txtListMontant = (TextView)convertView.findViewById(R.id.txtListMontant) ;
			holder.txtListMotif = (TextView)convertView.findViewById(R.id.txtListMotif) ;
			holder.imgSupprimerLigne = (ImageView)convertView.findViewById(R.id.imgSupprimerLigne);
			convertView.setTag(holder) ;
		}else{
			holder = (ViewHolder)convertView.getTag();
		}
		holder.txtListJour.setText(lesFrais.get(index).getJour().toString()) ;
		holder.txtListMontant.setText(lesFrais.get(index).getMontant().toString()) ;
		holder.txtListMotif.setText(lesFrais.get(index).getMotif()) ;
		holder.imgSupprimerLigne.setTag(index);
		holder.imgSupprimerLigne.setOnClickListener(new ImageView.OnClickListener(){
			public void onClick(View v) {
				supprlistener.onSupprClick((Integer)v.getTag());
			}
		});
		return convertView ;
	}
	
	/**
	 * 	  Interface de gestion des clics de suppression de ligne
	 
	 * @author Franck Noel
	 * 
	 *
	 */
	public interface SupprClicListener{
		public abstract void onSupprClick(int index);
	}
}
