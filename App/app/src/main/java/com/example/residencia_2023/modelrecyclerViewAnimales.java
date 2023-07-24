package com.example.residencia_2023;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.util.Base64;

import java.util.ArrayList;

public class modelrecyclerViewAnimales {
    private String fotografiaRegistro, fechaRegistro, horaRegistro;

    public modelrecyclerViewAnimales(String fotr, String fr, String hr) {
        fotografiaRegistro = fotr;
        fechaRegistro = fr;
        horaRegistro = hr;
    }

    public Bitmap getFotografia()
    {
        byte[] decodedString = Base64.decode(fotografiaRegistro, Base64.DEFAULT);
        Bitmap fotografia = BitmapFactory.decodeByteArray(decodedString, 0, decodedString.length);


        return fotografia;
    }

    public String getFecha() {
        return fechaRegistro;
    }

    public String getHora() {
        return horaRegistro;
    }
    private static int animalId = 0;
}
