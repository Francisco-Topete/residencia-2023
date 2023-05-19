package com.example.residencia_2023;

import androidx.appcompat.app.AppCompatActivity;

import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class activityAnadirAnimal extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_anadir_animal);

        AsyncTask.execute(new Runnable() {
            @Override
            public void run()
            {
                URL endpoint;
                String respuesta = "";

                try
                {
                    endpoint = new URL("http://ec2-18-216-202-90.us-east-2.compute.amazonaws.com/api/" +
                            "apiCallSelectOptions.php");
                    HttpURLConnection conn =
                            (HttpURLConnection) endpoint.openConnection();

                    conn.setRequestProperty("User-Agent", "residencias");
                    conn.setRequestProperty("Content-Type", "application/json");
                    conn.setRequestProperty("Accept", "application/json");
                    conn.setRequestMethod("POST");

                    try(BufferedReader br = new BufferedReader(
                            new InputStreamReader(conn.getInputStream()))) {
                        StringBuilder response = new StringBuilder();
                        String responseLine = null;

                        while ((responseLine = br.readLine()) != null)
                        {
                            response.append(responseLine.trim());
                        }

                        respuesta = response.toString();
                        Log.d("JSON: ", respuesta);
                    }
                }
                catch(Exception e)
                {
                    e.printStackTrace();
                }
            }
        });
    }
}