package com.example.residencia_2023;

import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;

import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Handler;
import android.os.Looper;
import android.util.Log;
import android.view.View;

import androidx.appcompat.widget.Toolbar;
import androidx.fragment.app.FragmentTransaction;
import androidx.navigation.NavController;
import androidx.navigation.Navigation;
import androidx.navigation.ui.AppBarConfiguration;
import androidx.navigation.ui.NavigationUI;

import com.example.residencia_2023.databinding.ActivityRescatistaHomeBinding;

import android.view.Menu;
import android.view.MenuItem;
import android.view.animation.AnimationUtils;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class activityRescatistaHome extends AppCompatActivity {
    boolean doubleBackToExitPressedOnce = false;
    private AppBarConfiguration appBarConfiguration;
    private ActivityRescatistaHomeBinding binding;
    FragmentTransaction ft = getSupportFragmentManager().beginTransaction();



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        ft.replace(R.id.framelayoutFragment, new fragmentRescatistaHomeMain());
        ft.commit();
        Toolbar toolbarMain = (Toolbar) findViewById(R.id.toolbarMain);
        setSupportActionBar(toolbarMain);
        binding = ActivityRescatistaHomeBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());
        ImageView imageViewToolbarAnadirAnimal = (ImageView) findViewById(R.id.imageViewToolbarAnadirAnimal);
        imageViewToolbarAnadirAnimal.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View view)
            {
                view.startAnimation(AnimationUtils.loadAnimation(activityRescatistaHome.this,R.anim.imageclick));
                Handler handler=new Handler(Looper.getMainLooper());
                handler.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        Intent intent = new Intent(activityRescatistaHome.this,
                                activityAnadirAnimal.class);
                        startActivity(intent);
                    }
                },10);
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