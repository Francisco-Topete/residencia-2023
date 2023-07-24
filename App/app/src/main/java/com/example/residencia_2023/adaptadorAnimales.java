package com.example.residencia_2023;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.recyclerview.widget.RecyclerView;

import java.util.List;

public abstract class adaptadorAnimales extends RecyclerView.Adapter<adaptadorAnimales.ViewHolder>
{
    public class ViewHolder extends RecyclerView.ViewHolder
    {
        public TextView textviewFecha, textviewHora;
        public ImageView imageviewAnimal, imageviewEditar;

        public ViewHolder(View itemView) {
            // Stores the itemView in a public final member variable that can be used
            // to access the context from any ViewHolder instance.
            super(itemView);

            textviewFecha = (TextView) itemView.findViewById(R.id.textViewFechaRV);
            textviewHora = (TextView) itemView.findViewById(R.id.textViewHoraRV);
            imageviewAnimal = (ImageView) itemView.findViewById(R.id.imageViewAnimalRV);
            imageviewEditar = (ImageView) itemView.findViewById(R.id.imageViewEditarAnimalRV2);
        }
    }

    private List<modelrecyclerViewAnimales> listaAnimales;

    // Pass in the contact array into the constructor
    public adaptadorAnimales(List<modelrecyclerViewAnimales> lm) {
        listaAnimales = lm;
    }

    @Override
    public adaptadorAnimales.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        Context context = parent.getContext();
        LayoutInflater inflater = LayoutInflater.from(context);

        View recyclerViewAnimales = inflater.inflate(R.layout.item_recyclerview, parent, false);

        ViewHolder viewHolder = new ViewHolder(recyclerViewAnimales);
        return viewHolder;
    }

    // Involves populating data into the item through holder
    @Override
    public void onBindViewHolder(adaptadorAnimales.ViewHolder holder, int position) {
        modelrecyclerViewAnimales animal = listaAnimales.get(position);

        TextView textViewFechaRVI = holder.textviewFecha;
        textViewFechaRVI.setText(animal.getFecha());

        TextView textViewHoraRVI = holder.textviewHora;
        textViewHoraRVI.setText(animal.getHora());

        ImageView imageViewRVI = holder.imageviewAnimal;
        imageViewRVI.setImageBitmap(animal.getFotografia());

    }

    @Override
    public int getItemCount() {
        return listaAnimales.size();
    }
}
