package com.example.residencia_2023;

import androidx.appcompat.app.AppCompatActivity;

import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

import java.net.URL;

public class activityInicioSesion extends AppCompatActivity {

    Button buttonLogin = (Button) findViewById(R.id.buttonLogin);
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inicio_sesion);

        buttonLogin.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View view)
            {
                AsyncTask.execute(new Runnable() {
                    @Override
                    public void run()
                    {
                        //URL endpoint = new URL();
                    }
                });
            }
        });
    }
}