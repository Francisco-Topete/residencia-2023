package com.example.residencia_2023;

import static android.view.View.INVISIBLE;
import static android.view.View.VISIBLE;
import static java.sql.DriverManager.println;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.telephony.PhoneNumberFormattingTextWatcher;
import android.util.Log;
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
    boolean doubleBackToExitPressedOnce = false;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inicio_sesion);

        Button buttonLogin = (Button) findViewById(R.id.buttonLogin);

        EditText textboxLoginUsuario = (EditText) findViewById(R.id.textboxLoginUsuario);
        textboxLoginUsuario.addTextChangedListener(new PhoneNumberFormattingTextWatcher("MX"));


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
                        String telefono = formatearTelefono(textboxLoginUsuario.getText().toString());
                        Log.d("Telefono formateado: ", telefono);
                        String contrasena = textboxLoginContrasena.getText().toString();
                        String respuesta = "";

                        try
                        {
                            endpoint = new URL("http://ec2-18-216-202-90.us-east-2.compute.amazonaws.com/api/" +
                                    "apilogin.php");
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

                                conn.disconnect();

                                jsonLogin = "";
                                respuesta = response.toString();
                                Log.d("Respuesta ", respuesta);

                                buttonLogin.setClickable(false);
                                textboxLoginUsuario.setClickable(false);
                                textboxLoginContrasena.setClickable(false);

                                if(respuesta.contains("Correcta"))
                                {
                                    loginSuccess();
                                }
                                else
                                {
                                    respuesta=clearLogin();
                                    loginFail();
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

            public String formatearTelefono(String s)
            {
                s = s.replace(" ", "");

                if(s.length() >= 10) {
                    char[] telefonoCaracteres = s.toCharArray();

                    String mascara = "(xxx) xxx-xxxx";
                    char[] mascaraCaracteres = mascara.toCharArray();

                    StringBuilder telefonoFormateado = new StringBuilder();

                    int y = 0;
                    for (int x = 0; x < mascara.length(); x++) {
                        if (mascaraCaracteres[x] == '(' || mascaraCaracteres[x] == ')' || mascaraCaracteres[x] == '-' || mascaraCaracteres[x] == ' ') {
                            telefonoFormateado.append(mascaraCaracteres[x]);
                        } else {
                            if (mascaraCaracteres[x] == 'x') {
                                telefonoFormateado.append(telefonoCaracteres[y]);
                                y++;
                            }
                        }
                    }

                    s = telefonoFormateado.toString();
                    return s;
                }
                else
                {
                    return "000000000";
                }
            }

            public void loginSuccess()
            {
                Thread thread = new Thread(){
                    public void run(){
                        runOnUiThread(new Runnable() {
                            public void run() {
                                findViewById(R.id.loadingPanel).setVisibility(VISIBLE);
                            }
                        });
                    }
                };

                thread.start();
                Handler handler=new Handler(Looper.getMainLooper());
                handler.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        Intent intent = new Intent(activityInicioSesion.this,
                                activityRescatistaHome.class);
                        startActivity(intent);
                        finish();
                    }
                },2000);
            }
            public void loginFail()
            {
                Thread thread = new Thread(){
                    public void run(){
                        runOnUiThread(new Runnable() {
                            public void run() {
                                findViewById(R.id.loadingPanel).setVisibility(VISIBLE);
                            }
                        });
                    }
                };
                thread.start();

                Handler handler=new Handler(Looper.getMainLooper());
                handler.postDelayed(new Runnable() {
                    public void run(){
                        buttonLogin.setClickable(true);
                        textboxLoginUsuario.setClickable(true);
                        textboxLoginContrasena.setClickable(true);
                        findViewById(R.id.loadingPanel).setVisibility(INVISIBLE);
                        runOnUiThread(new Runnable() {
                            public void run() {
                                Toast loginErroneo = Toast.makeText(getApplicationContext(),
                                        "Datos incorrectos, vuelvalo a intentar",Toast.LENGTH_SHORT);
                                loginErroneo.show();
                            }
                        });
                    }
                },2000);
            }
        });
    }
    @Override
    public void onBackPressed() {
        if (doubleBackToExitPressedOnce) {
            super.onBackPressed();
            return;
        }

        this.doubleBackToExitPressedOnce = true;
        Toast.makeText(this, "Presiona atras de nuevo para salir.", Toast.LENGTH_SHORT).show();

        new Handler(Looper.getMainLooper()).postDelayed(new Runnable() {
            @Override
            public void run() {
                doubleBackToExitPressedOnce=false;
            }
        }, 2000);
    }
}