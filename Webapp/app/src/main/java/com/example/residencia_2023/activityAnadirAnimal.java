package com.example.residencia_2023;

import static android.view.View.INVISIBLE;
import static android.view.View.VISIBLE;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContract;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import android.Manifest;
import android.app.Activity;
import android.content.ContentValues;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.ImageDecoder;
import android.graphics.Matrix;
import android.location.Location;
import android.location.LocationManager;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.provider.MediaStore;
import android.provider.Settings;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.view.animation.AnimationUtils;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.URL;
import java.nio.charset.StandardCharsets;
import java.util.ArrayList;
import java.util.List;

public class activityAnadirAnimal extends AppCompatActivity {
    private static final int PERMISSION_CODE = 1234;
    Uri fotoUri;
    ImageView imageViewFotoAnimal;
    Button buttonRegistrarAnimal;
    Spinner spinnerEspecie, spinnerRaza, spinnerSexo, spinnerEdad, spinnerSituacion,
            spinnerProblemasSalud, spinnerHeridas, spinnerComportamiento;
    Location gps_loc;
    Location network_loc;
    Location final_loc;
    double longitude;
    double latitude;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_anadir_animal);
        imageViewFotoAnimal = (ImageView) findViewById(R.id.imageViewPhoto);
        buttonRegistrarAnimal = (Button) findViewById(R.id.buttonRegistrarAnimal);
        definirSpinners();
        permisosInicializar();
        imageViewFotoAnimal.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View view)
            {
                view.startAnimation(AnimationUtils.loadAnimation(activityAnadirAnimal.this,R.anim.imageclick));
                Handler handler=new Handler(Looper.getMainLooper());
                handler.postDelayed(new Runnable() {
                    @Override
                    public void run()
                    {
                        tomarFoto();
                    }
                },10);
            }
        });

        buttonRegistrarAnimal.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View view)
            {
                AsyncTask.execute(new Runnable() {
                    @Override
                    public void run()
                    {
                        try
                        {
                            URL endpoint;

                            String animalEspecie = spinnerEspecie.getSelectedItem().toString(),
                                    animalRaza = spinnerRaza.getSelectedItem().toString(),
                                    animalSexo = spinnerSexo.getSelectedItem().toString(),
                                    animalEdad = spinnerEdad.getSelectedItem().toString(),
                                    animalSituacion = spinnerSituacion.getSelectedItem().toString(),
                                    animalProblemasSalud = spinnerProblemasSalud.getSelectedItem().toString(),
                                    animalHeridas = spinnerHeridas.getSelectedItem().toString(),
                                    animalComportamiento = spinnerComportamiento.getSelectedItem().toString();

                            Bitmap bitmap = MediaStore.Images.Media.getBitmap(getContentResolver(), fotoUri);
                            Matrix matrix = new Matrix();
                            matrix.postRotate(90);
                            Bitmap bitmap2 = Bitmap.createBitmap(bitmap, 0, 0, bitmap.getWidth(), bitmap.getHeight(), matrix, true);

                            int MAX_ALLOWED_RESOLUTION = 1024;
                            int outWidth;
                            int outHeight;
                            int inWidth = bitmap2.getWidth();
                            int inHeight = bitmap2.getHeight();
                            if(inWidth > inHeight){
                                outWidth = MAX_ALLOWED_RESOLUTION;
                                outHeight = (inHeight * MAX_ALLOWED_RESOLUTION) / inWidth;
                            } else {
                                outHeight = MAX_ALLOWED_RESOLUTION;
                                outWidth = (inWidth * MAX_ALLOWED_RESOLUTION) / inHeight;
                            }

                            Bitmap bitmapFinal = Bitmap.createScaledBitmap(bitmap2, outWidth, outHeight, false);

                            ByteArrayOutputStream baos = new ByteArrayOutputStream();
                            bitmapFinal.compress(Bitmap.CompressFormat.JPEG, 100, baos);
                            byte[] b = baos.toByteArray();
                            byte[] b64 = Base64.encode(b,Base64.DEFAULT);
                            String animalFoto = new String(b64, StandardCharsets.UTF_8);

                            JSONObject jsonAnimal = new JSONObject();
                            jsonAnimal.put("fotografia",animalFoto);
                            jsonAnimal.put("especie",animalEspecie);
                            jsonAnimal.put("raza",animalRaza);
                            //jsonAnimal.put("sexo",animalSexo);
                            jsonAnimal.put("situacion",animalSituacion);
                            jsonAnimal.put("edad",animalEdad);
                            jsonAnimal.put("problemas_salud",animalProblemasSalud);
                            jsonAnimal.put("heridas",animalHeridas);
                            jsonAnimal.put("comportamiento",animalComportamiento);
                            jsonAnimal.put("locacion_latitud",latitude);
                            jsonAnimal.put("locacion_longitud",longitude);
                            String jsonStringAnimal = jsonAnimal.toString();
                            Log.d("JSON",jsonStringAnimal);

                            endpoint = new URL("http://ec2-18-216-202-90.us-east-2.compute.amazonaws.com/api/" +
                                    "apiMap.php");
                            HttpURLConnection conn =
                                    (HttpURLConnection) endpoint.openConnection();

                            conn.setRequestProperty("User-Agent", "residencias");
                            conn.setRequestProperty("Content-Type", "application/json");
                            conn.setRequestProperty("Accept", "application/json");
                            conn.setRequestMethod("POST");
                            conn.setDoOutput(true);
                            conn.setChunkedStreamingMode(0);

                            mandarAnimalAPI();
                            OutputStreamWriter wr = new OutputStreamWriter(conn.getOutputStream());
                            wr.write(jsonStringAnimal);
                            wr.flush();

                            conn.disconnect();
                        }
                        catch(Exception e)
                        {
                            e.printStackTrace();
                        }
                    }
                });
            }
        });

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

                        conn.disconnect();

                        respuesta = response.toString();
                        construirSpinners(respuesta);
                    }
                }
                catch(Exception e)
                {
                    e.printStackTrace();
                }
            }
        });
    }

    public void permisosInicializar()
    {
        String[] permission = {Manifest.permission.CAMERA,Manifest.permission.WRITE_EXTERNAL_STORAGE,Manifest.permission.ACCESS_FINE_LOCATION,Manifest.permission.ACCESS_COARSE_LOCATION,Manifest.permission.ACCESS_NETWORK_STATE};
        requestPermissions(permission, PERMISSION_CODE);
        Log.d("Permisos:","Si");
    }

    public void locationWizard(){
        LocationManager locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);

        try
        {
            gps_loc = locationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
            network_loc = locationManager.getLastKnownLocation(LocationManager.NETWORK_PROVIDER);
        }
        catch (SecurityException se)
        {
            se.printStackTrace();
        }

        if (gps_loc != null) {
            final_loc = gps_loc;
            latitude = final_loc.getLatitude();
            longitude = final_loc.getLongitude();
        }
        else if (network_loc != null) {
            final_loc = network_loc;
            latitude = final_loc.getLatitude();
            longitude = final_loc.getLongitude();
        }
        else {
            latitude = 0.0;
            longitude = 0.0;
        }

        Log.d("Latitud",String.valueOf(latitude));

        Log.d("Longitud",String.valueOf(longitude));
    }

    public void mandarAnimalAPI()
    {
        Thread thread = new Thread(){
            public void run(){
                runOnUiThread(new Runnable() {
                    public void run() {
                        findViewById(R.id.loadingPanelAnadirAnimal).setVisibility(VISIBLE);
                    }
                });
            }
        };
        thread.start();

        Handler handler=new Handler(Looper.getMainLooper());
        handler.postDelayed(new Runnable() {
            public void run(){
                findViewById(R.id.loadingPanelAnadirAnimal).setVisibility(INVISIBLE);
                runOnUiThread(new Runnable() {
                    public void run() {
                        Toast cargaAnimal = Toast.makeText(getApplicationContext(),
                                "Animal anadido al mapa!",Toast.LENGTH_SHORT);
                        cargaAnimal.show();
                    }
                });
            }
        },2000);
    }

    public void construirSpinners(String respuesta)
    {
        try
        {
            JSONObject jsonData = new JSONObject(respuesta);

            JSONArray arrayEspecie = jsonData.getJSONArray("Especies");
            ArrayList<String> listaEspecie = new ArrayList();
            for (int x = 0; x < arrayEspecie.length(); x++)
            {
                JSONObject jsonEspecieNombre = arrayEspecie.getJSONObject(x);
                listaEspecie.add(jsonEspecieNombre.getString("Nombre"));
            }
            ArrayAdapter<String> adapterEspecie = new ArrayAdapter<String>(
                    this, R.layout.customspinner, listaEspecie);

            JSONArray arrayRaza = jsonData.getJSONArray("Razas");
            ArrayList<String> listaRaza = new ArrayList();
            for (int x = 0; x < arrayRaza.length(); x++)
            {
                JSONObject jsonRazaNombre = arrayRaza.getJSONObject(x);
                listaRaza.add(jsonRazaNombre.getString("Nombre"));
            }
            ArrayAdapter<String> adapterRaza = new ArrayAdapter<String>(
                    this, R.layout.customspinner, listaRaza);

            ArrayList<String> listaSexo = new ArrayList();
            listaSexo.add("Macho");
            listaSexo.add("Hembra");
            ArrayAdapter<String> adapterSexo = new ArrayAdapter<String>(
                    this, R.layout.customspinner, listaSexo);

            JSONArray arraySituacion = jsonData.getJSONArray("Situacion");
            ArrayList<String> listaSituacion = new ArrayList();
            for (int x = 0; x < arraySituacion.length(); x++)
            {
                JSONObject jsonSituacionNombre = arraySituacion.getJSONObject(x);
                listaSituacion.add(jsonSituacionNombre.getString("Nombre"));
            }
            ArrayAdapter<String> adapterSituacion = new ArrayAdapter<String>(
                    this, R.layout.customspinner, listaSituacion);

            JSONArray arrayEdad = jsonData.getJSONArray("Edad");
            ArrayList<String> listaEdad = new ArrayList();
            for (int x = 0; x < arrayEdad.length(); x++)
            {
                JSONObject jsonEdadNombre = arrayEdad.getJSONObject(x);
                listaEdad.add(jsonEdadNombre.getString("Nombre"));
            }
            ArrayAdapter<String> adapterEdad = new ArrayAdapter<String>(
                    this, R.layout.customspinner, listaEdad);

            JSONArray arrayProblemasSalud = jsonData.getJSONArray("Problemas_Salud");
            ArrayList<String> listaProblemasSalud = new ArrayList();
            for (int x = 0; x < arrayProblemasSalud.length(); x++)
            {
                JSONObject jsonProblemasSaludNombre = arrayProblemasSalud.getJSONObject(x);
                listaProblemasSalud.add(jsonProblemasSaludNombre.getString("Nombre"));
            }
            ArrayAdapter<String> adapterProblemasSalud = new ArrayAdapter<String>(
                    this, R.layout.customspinner, listaProblemasSalud);

            JSONArray arrayHeridas = jsonData.getJSONArray("Heridas");
            ArrayList<String> listaHeridas = new ArrayList();
            for (int x = 0; x < arrayHeridas.length(); x++)
            {
                JSONObject jsonHeridasNombre = arrayHeridas.getJSONObject(x);
                listaHeridas.add(jsonHeridasNombre.getString("Nombre"));
            }
            ArrayAdapter<String> adapterHeridas = new ArrayAdapter<String>(
                    this, R.layout.customspinner, listaHeridas);

            JSONArray arrayComportamiento = jsonData.getJSONArray("Comportamiento");
            ArrayList<String> listaComportamiento = new ArrayList();
            for (int x = 0; x < arrayComportamiento.length(); x++)
            {
                JSONObject jsonComportamientoNombre = arrayComportamiento.getJSONObject(x);
                listaComportamiento.add(jsonComportamientoNombre.getString("Nombre"));
            }
            ArrayAdapter<String> adapterComportamiento = new ArrayAdapter<String>(
                    this, R.layout.customspinner, listaComportamiento);

            Thread thread = new Thread(){
                public void run(){
                    runOnUiThread(new Runnable() {
                        public void run() {
                            adapterEspecie.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                            spinnerEspecie.setAdapter(adapterEspecie);

                            adapterRaza.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                            spinnerRaza.setAdapter(adapterRaza);

                            adapterSexo.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                            spinnerSexo.setAdapter(adapterSexo);

                            adapterSituacion.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                            spinnerSituacion.setAdapter(adapterSituacion);

                            adapterEdad.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                            spinnerEdad.setAdapter(adapterEdad);

                            adapterProblemasSalud.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                            spinnerProblemasSalud.setAdapter(adapterProblemasSalud);

                            adapterHeridas.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                            spinnerHeridas.setAdapter(adapterHeridas);

                            adapterComportamiento.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                            spinnerComportamiento.setAdapter(adapterComportamiento);
                        }
                    });
                }
            };

            thread.start();
        }
        catch(Exception e)
        {
            e.printStackTrace();
        }
    }

    public void definirSpinners()
    {
        spinnerEspecie = (Spinner) findViewById(R.id.spinnerEspecie);
        spinnerRaza = (Spinner) findViewById(R.id.spinnerRaza);
        spinnerSexo = (Spinner) findViewById(R.id.spinnerSexo);
        spinnerSituacion = (Spinner) findViewById(R.id.spinnerSituacion);
        spinnerEdad = (Spinner) findViewById(R.id.spinnerEdad);
        spinnerProblemasSalud = (Spinner) findViewById(R.id.spinnerProblemasSalud);
        spinnerHeridas = (Spinner) findViewById(R.id.spinnerHeridas);
        spinnerComportamiento = (Spinner) findViewById(R.id.spinnerComportamiento);
    }

    public void tomarFoto()
    {
        ContentValues fotoPropiedades = new ContentValues();
        fotoUri = getContentResolver().insert(MediaStore.Images.Media.EXTERNAL_CONTENT_URI,fotoPropiedades);

        Intent camIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        camIntent.putExtra(MediaStore.EXTRA_OUTPUT, fotoUri);
        Log.d("Se hizo","Creo");
        camActivityResultLauncher.launch(camIntent);
    }

    ActivityResultLauncher<Intent> camActivityResultLauncher = registerForActivityResult(
            new ActivityResultContracts.StartActivityForResult(),
            new ActivityResultCallback<ActivityResult>() {
                @Override
                public void onActivityResult(ActivityResult result) {
                    if (result.getResultCode() == Activity.RESULT_OK) {
                        // There are no request codes
                        Intent data = result.getData();
                        imageViewFotoAnimal.setImageURI(fotoUri);
                    }
                }
            });

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);

        switch(requestCode)
        {
            case PERMISSION_CODE:
                Log.d("Resultado del permiso","Veamos");
                if(grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED
                        && grantResults[1] == PackageManager.PERMISSION_GRANTED
                        && grantResults[2] == PackageManager.PERMISSION_GRANTED)
                {
                    locationWizard();
                }
                else
                {
                    new AlertDialog.Builder(activityAnadirAnimal.this)
                            .setMessage("Ocupas todos los permisos para poder utilizar el formulario.")
                            .setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface paramDialogInterface, int paramInt) {
                                    Intent intent = new Intent(activityAnadirAnimal.this,
                                            activityRescatistaHome.class);
                                    startActivity(intent);
                                    finish();
                                }
                            })
                            .show();
                }
        }
    }
}