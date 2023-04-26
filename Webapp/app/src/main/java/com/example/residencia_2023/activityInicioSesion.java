package com.example.residencia_2023;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;

import javax.net.ssl.HttpsURLConnection;

public class activityInicioSesion extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inicio_sesion);

        Button buttonLogin = (Button) findViewById(R.id.buttonLogin);
        EditText textboxLoginUsuario = (EditText) findViewById(R.id.textboxLoginUsuario);
        EditText textboxLoginContrasena = (EditText) findViewById(R.id.textboxLoginContrasena);

        buttonLogin.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View view)
            {
                AsyncTask.execute(new Runnable() {
                    @Override
                    public void run()
                    {
                        URL endpoint;
                        String telefono = textboxLoginUsuario.getText().toString();
                        String contrasena = textboxLoginContrasena.getText().toString();
                        String respuesta = "";

                        try
                        {
                            endpoint = new URL("http://201.170.172.111:8080/residencia-2023/" +
                                    "Login_html_css-main/apilogin.php");
                            HttpURLConnection conn =
                                    (HttpURLConnection) endpoint.openConnection();

                            conn.setRequestProperty("User-Agent", "residencias");
                            conn.setRequestProperty("Content-Type", "application/json");
                            conn.setRequestProperty("Accept", "application/json");
                            conn.setRequestMethod("POST");
                            conn.setDoOutput(true);

                            String jsonLogin = "{\"telefono\": \"" + telefono +
                                    "\", \"contrasena\": \"" + contrasena + "\"}";

                            telefono = "";
                            contrasena = "";

                            conn.getOutputStream().write(jsonLogin.getBytes());

                            try(BufferedReader br = new BufferedReader(
                                    new InputStreamReader(conn.getInputStream()))) {
                                StringBuilder response = new StringBuilder();
                                String responseLine = null;

                                while ((responseLine = br.readLine()) != null)
                                {
                                    response.append(responseLine.trim());
                                }

                                jsonLogin = "";
                                respuesta = response.toString();

                                if(respuesta.contains("Correcta"))
                                {
                                    Handler handler=new Handler();
                                    handler.postDelayed(new Runnable() {
                                        @Override
                                        public void run() {
                                            Intent intent = new Intent(activityInicioSesion.this,
                                                    activityInicioSesion.class);
                                            startActivity(intent);
                                        }
                                    },4000);
                                }
                                else
                                {
                                    respuesta=clearLogin();

                                    Toast loginErroneo=Toast.makeText(getApplicationContext(),
                                            "Datos incorrectos, vuelvalo a intentar",Toast.LENGTH_SHORT);
                                    loginErroneo.setMargin(50,50);
                                    loginErroneo.show();
                                }
                            }

                        }
                        catch(Exception e)
                        {
                            e.printStackTrace();
                        }
                    }
                });
            }

            public String clearLogin()
            {
                textboxLoginUsuario.setText("");
                textboxLoginContrasena.setText("");
                textboxLoginUsuario.hasFocus();

                return "";
            }
        });
    }
}