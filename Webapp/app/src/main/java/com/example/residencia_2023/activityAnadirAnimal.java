package com.example.residencia_2023;

import static android.view.View.VISIBLE;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContract;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.Manifest;
import android.app.Activity;
import android.content.ContentValues;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.view.animation.AnimationUtils;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.Spinner;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

public class activityAnadirAnimal extends AppCompatActivity {
    private static final int PERMISSION_CODE = 1234;
    Uri fotoUri;
    ImageView imageViewFotoAnimal;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_anadir_animal);
        imageViewFotoAnimal = (ImageView) findViewById(R.id.imageViewPhoto);
        imageViewFotoAnimal.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View view)
            {
                view.startAnimation(AnimationUtils.loadAnimation(activityAnadirAnimal.this,R.anim.imageclick));
                Handler handler=new Handler(Looper.getMainLooper());
                handler.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        if(Build.VERSION.SDK_INT >= Build.VERSION_CODES.M)
                        {
                            if(checkSelfPermission(Manifest.permission.CAMERA) == PackageManager.PERMISSION_DENIED ||
                               checkSelfPermission(Manifest.permission.WRITE_EXTERNAL_STORAGE) == PackageManager.PERMISSION_DENIED)
                            {
                                String[] permission = {Manifest.permission.CAMERA,Manifest.permission.WRITE_EXTERNAL_STORAGE};
                                requestPermissions(permission, PERMISSION_CODE);
                                Log.d("Permisos","Si");
                            }
                            else
                            {
                                tomarFoto();
                            }
                        }
                    }
                },10);
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
            Thread thread = new Thread(){
                public void run(){
                    runOnUiThread(new Runnable() {
                        public void run() {
                            adapterEspecie.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                            Spinner spinnerEspecie = (Spinner) findViewById(R.id.spinnerEspecie);
                            spinnerEspecie.setAdapter(adapterEspecie);
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

    public void tomarFoto()
    {
        ContentValues fotoPropiedades = new ContentValues();
        fotoPropiedades.put(MediaStore.Images.Media.TITLE,"Fotografia del animal");
        fotoPropiedades.put(MediaStore.Images.Media.DESCRIPTION,"Cuidese");
        fotoUri = getContentResolver().insert(MediaStore.Images.Media.EXTERNAL_CONTENT_URI, fotoPropiedades);

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
                if(grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED)
                {
                    Log.d("Si ves esto","Si se armo");
                    tomarFoto();
                }
                Log.d("Y esto","Es meh");
        }
    }
}