package com.example.residencia_2023;

import static android.view.View.INVISIBLE;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Bundle;

import androidx.appcompat.app.AlertDialog;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.os.Handler;
import android.os.Looper;
import android.provider.Settings;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.AnimationUtils;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link fragmentRescatistaHomeMain#newInstance} factory method to
 * create an instance of this fragment.
 */
public class fragmentRescatistaHomeMain extends Fragment{

    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    public RecyclerView rvAnimales;
    public EditText textboxBusqueda;

    public ImageView imageviewEditar, imageviewRegistrar;

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    public fragmentRescatistaHomeMain() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment fragmentRescatistaHomeMain.
     */
    // TODO: Rename and change types and number of parameters
    public static fragmentRescatistaHomeMain newInstance(String param1, String param2) {
        fragmentRescatistaHomeMain fragment = new fragmentRescatistaHomeMain();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mParam1 = getArguments().getString(ARG_PARAM1);
            mParam2 = getArguments().getString(ARG_PARAM2);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_rescatista_home_main, container, false);
    }

    @Override
    public void onViewCreated(View view, Bundle savedInstanceState)
    {
        imageviewRegistrar = (ImageView) getActivity().findViewById(R.id.imageViewToolbarAnadirAnimal);

        adaptarRecyclerView();
        busquedaTexto(view);
        //editarRegistro(view);
    }

    public void editarRegistro(View view)
    {
        imageviewEditar = (ImageView) view.findViewById(R.id.imageViewEditarAnimalRV2);

        imageviewEditar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View viewimg)
            {
                viewimg.startAnimation(AnimationUtils.loadAnimation(getActivity(), R.anim.imageclick));

                Handler handler=new Handler(Looper.getMainLooper());
                handler.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        LocationManager lm = (LocationManager) getActivity().getSystemService(Context.LOCATION_SERVICE);
                        boolean gps_enabled = false;
                        boolean network_enabled = false;

                        try {
                            gps_enabled = lm.isProviderEnabled(LocationManager.GPS_PROVIDER);
                        } catch(Exception ex) {}

                        try {
                            network_enabled = lm.isProviderEnabled(LocationManager.NETWORK_PROVIDER);
                        } catch(Exception ex) {}

                        if(!gps_enabled || !network_enabled) {
                            // notify user
                            new AlertDialog.Builder(getActivity())
                                    .setMessage("Por favor asegurate de tener conexion a internet y la localizacion prendida.")
                                    .setPositiveButton("Activar", new DialogInterface.OnClickListener() {
                                        @Override
                                        public void onClick(DialogInterface paramDialogInterface, int paramInt) {
                                            startActivity(new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS));
                                        }
                                    })
                                    .setNegativeButton("Cancelar",null)
                                    .show();
                        }
                        else
                        {
                            Intent intent = new Intent(getActivity(),
                                    activityAnadirAnimal.class);
                            startActivity(intent);
                        }
                    }
                },10);
            }
        });
    }

    public void busquedaTexto(View view)
    {
        textboxBusqueda = (EditText) view.findViewById(R.id.textboxBusquedaFecha);
        textboxBusqueda.addTextChangedListener(new TextWatcher() {

            @Override
            public void afterTextChanged(Editable s)
            {
                if(!textboxBusqueda.isFocused())
                {
                    actualizarRecyclerView(s.toString());
                }
            }

            @Override
            public void beforeTextChanged(CharSequence s, int start,
                                          int count, int after)
            {

            }

            @Override
            public void onTextChanged(CharSequence s, int start,
                                      int before, int count)
            {
            }
        });
    }

    public void actualizarRecyclerView(String cambios)
    {
        rvAnimales = (RecyclerView) getView().findViewById(R.id.recyclerViewAnimales);

        new Thread(new Runnable() {
            public void run() {

                if(getActivity() == null)
                    return;
                getActivity().runOnUiThread(new Runnable() {
                    public void run()
                    {
                        getActivity().findViewById(R.id.loadingPanelHome).setVisibility(View.VISIBLE);
                        imageviewRegistrar.setClickable(false);
                        imageviewRegistrar.setEnabled(false);
                    }
                });
            }
        }).start();

        AsyncTask.execute(new Runnable() {
            @Override
            public void run()
            {
                URL endpoint;
                String respuesta = "";

                try
                {
                    endpoint = new URL("https://www.censoanimalesbc.com/api/" +
                            "apiAnimalData.php");
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
                        ArrayList<modelrecyclerViewAnimales> animales = reconstruirRVI(respuesta,cambios);

                        Thread thread = new Thread()
                        {
                            public void run()
                            {
                                if(getActivity() == null)
                                    return;
                                getActivity().runOnUiThread(new Runnable() {
                                    public void run()
                                    {
                                        adaptadorAnimales adapter = new adaptadorAnimales(animales) {
                                        };
                                        rvAnimales.setAdapter(adapter);
                                        rvAnimales.setLayoutManager(new LinearLayoutManager(getActivity()));
                                        getActivity().findViewById(R.id.loadingPanelHome).setVisibility(INVISIBLE);
                                        imageviewRegistrar.setClickable(true);
                                        imageviewRegistrar.setEnabled(true);
                                    }
                                });
                            }
                        };

                        thread.start();
                    }
                }
                catch(Exception e)
                {
                    e.printStackTrace();
                }
            }
        });
    }

    public void adaptarRecyclerView()
    {
        rvAnimales = (RecyclerView) getView().findViewById(R.id.recyclerViewAnimales);

        AsyncTask.execute(new Runnable() {
            @Override
            public void run()
            {
                URL endpoint;
                String respuesta = "";

                try
                {
                    endpoint = new URL("https://www.censoanimalesbc.com/api/" +
                            "apiAnimalData.php");
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
                        ArrayList<modelrecyclerViewAnimales> animales = construirRVI(respuesta);
                        Thread thread = new Thread()
                        {
                            public void run()
                            {
                                if(getActivity() == null)
                                    return;
                                getActivity().runOnUiThread(new Runnable() {
                                    public void run()
                                    {
                                        adaptadorAnimales adapter = new adaptadorAnimales(animales) {
                                        };
                                        rvAnimales.setAdapter(adapter);
                                        rvAnimales.setLayoutManager(new LinearLayoutManager(getActivity()));
                                        getActivity().findViewById(R.id.loadingPanelHome).setVisibility(INVISIBLE);
                                        imageviewRegistrar.setClickable(true);
                                        imageviewRegistrar.setEnabled(true);
                                    }
                                });
                            }
                        };

                        thread.start();
                    }
                }
                catch(Exception e)
                {
                    e.printStackTrace();
                }
            }
        });
    }

    public ArrayList<modelrecyclerViewAnimales> reconstruirRVI(String respuesta, String cambios)
    {
        try
        {
            JSONObject jsonData = new JSONObject(respuesta);

            JSONArray arrayData = jsonData.getJSONArray("Animales");
            ArrayList<modelrecyclerViewAnimales> listaAnimales = new ArrayList();

            for (int x = 0; x < arrayData.length(); x++)
            {
                JSONObject jsonAnimal = arrayData.getJSONObject(x);

                if(jsonAnimal.getString("Fecha").contains(cambios))
                {
                    listaAnimales.add(new modelrecyclerViewAnimales(jsonAnimal.getString("Foto"), jsonAnimal.getString("Fecha"), jsonAnimal.getString("Hora")));
                }
            }

            return listaAnimales;
        }
        catch(Exception e)
        {
            e.printStackTrace();
            return null;
        }
    }

    public ArrayList<modelrecyclerViewAnimales> construirRVI(String respuesta)
    {
        try
        {
            JSONObject jsonData = new JSONObject(respuesta);

            JSONArray arrayData = jsonData.getJSONArray("Animales");
            ArrayList<modelrecyclerViewAnimales> listaAnimales = new ArrayList();

            for (int x = 0; x < arrayData.length(); x++)
            {
                JSONObject jsonAnimal = arrayData.getJSONObject(x);
                listaAnimales.add(new modelrecyclerViewAnimales(jsonAnimal.getString("Foto"),jsonAnimal.getString("Fecha"),jsonAnimal.getString("Hora")));
            }

            return listaAnimales;
        }
        catch(Exception e)
        {
            e.printStackTrace();
            return null;
        }
    }
}