<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_table_pagofacil extends CI_Migration {

    public function up() {
        $query = "CREATE TABLE `pagofacil_acumulado` (
  `acumulado_id` int(11) NOT NULL,
  `acumulado_nro` varchar(150) NOT NULL,
  `acumulado_fecha` varchar(150) NOT NULL,
  `acumulado_cliente` varchar(150) NOT NULL,
  `acumulado_ev` varchar(150) NOT NULL,
  `acumulado_categ` varchar(150) NOT NULL,
  `acumulado_monto` varchar(150) NOT NULL,
  `acumulado_terminal` varchar(150) NOT NULL,
  `acumulado_fecha_cobrado` varchar(150) NOT NULL,
  `acumulado_hora` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($query);
        $query= "CREATE TABLE `pagofacil_archivos` (
  `archivo_id` int(11) DEFAULT NULL,
  `archivo_fecha` varchar(30) DEFAULT NULL,
  `archivo_nombre` varchar(150) DEFAULT NULL,
  `id_row` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
        $this->db->query($query);
        
        $query="ALTER TABLE `pagofacil_acumulado`
  ADD PRIMARY KEY (`acumulado_id`);";
        $this->db->query($query);
        $query="ALTER TABLE `pagofacil_archivos`
  ADD PRIMARY KEY (`id_row`);";
        $this->db->query($query);
        $query = "ALTER TABLE `pagofacil_acumulado`
  MODIFY `acumulado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=403;";
        $this->db->query($query);
        $query = "ALTER TABLE `pagofacil_archivos`
  MODIFY `id_row` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;";
        $this->db->query($query);
    }

    public function down() {
        
    }

}

