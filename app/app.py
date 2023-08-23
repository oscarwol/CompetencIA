
from datetime import datetime, timedelta
from pprint import pprint
import re
from flask import Flask, request, jsonify, send_file, make_response
from dotenv import load_dotenv
from flask_sqlalchemy import SQLAlchemy
from flask_marshmallow import Marshmallow
from flask_cors import CORS
from functools import wraps
from jwt import encode, decode
from werkzeug.utils import secure_filename
import os
from sqlalchemy.orm import Session
from sqlalchemy import func
from io import BytesIO
import pathlib
import xlsxwriter


CURRENT_PATH = pathlib.Path(__file__).parent.resolve()

host = "/backend"
app = Flask(__name__)
CORS(app)
url = "mysql+pymysql://devus:d3vc0mp7.23!@cptwol.clurs6kstakf.us-west-1.rds.amazonaws.com/Pruebas"
app.config["SQLALCHEMY_DATABASE_URI"] = os.environ.get('DATABASE_URL')
app.config["SQLALCHEMY_TRACK_MODIFICATIONS"] = False
app.config["SECRET_KEY"] = os.environ.get('SECRET_KEY')

db = SQLAlchemy(app)
ma = Marshmallow(app)
base = db.Model.metadata.reflect(db.engine)

session = Session(db.engine, future=True)

"""
Modelos y Esquemas
"""


class ETL_Diario(db.Model):
    __table__ = db.Model.metadata.tables["data_cpt"]

    def __init__(self, iddata_cpt, TIPO_REPORTE, CLIENTE, PAIS, FECHA, ANIO, MES, HORA, SECTOR, CATEGORIA, ANUNCIANTE, MARCA, PRODUCTO, VERSION, CAMPANIA, TIPO_MEDIO, SUBTIPO_DE_MEDIO, GRUPO_DE_MEDIOS, MEDIO, PROGRAMA, FRANJA, GENERO, AVISO, DISPOSITIVO, TIPO, AREA, ANCHO, ALTO, ADSERVER, AGENCIA, DURACION, SPOTS, IMPRESIONES, INVERSION_LOCAL, INVERSION_DOLARES):
        self.iddata_cpt = iddata_cpt
        self.TIPO_REPORTE = TIPO_REPORTE
        self.CLIENTE = CLIENTE
        self.PAIS = PAIS
        self.FECHA = FECHA
        self.ANIO = ANIO
        self.MES = MES
        self.HORA = HORA
        self.SECTOR = SECTOR
        self.CATEGORIA = CATEGORIA
        self.ANUNCIANTE = ANUNCIANTE
        self.MARCA = MARCA
        self.PRODUCTO = PRODUCTO
        self.VERSION = VERSION
        self.CAMPANIA = CAMPANIA
        self.TIPO_MEDIO = TIPO_MEDIO
        self.SUBTIPO_DE_MEDIO = SUBTIPO_DE_MEDIO
        self.GRUPO_DE_MEDIOS = GRUPO_DE_MEDIOS
        self.MEDIO = MEDIO
        self.PROGRAMA = PROGRAMA
        self.FRANJA = FRANJA
        self.GENERO = GENERO
        self.AVISO = AVISO
        self.DISPOSITIVO = DISPOSITIVO
        self.TIPO = TIPO
        self.AREA = AREA
        self.ANCHO = ANCHO
        self.ALTO = ALTO
        self.ADSERVER = ADSERVER
        self.AGENCIA = AGENCIA
        self.DURACION = DURACION
        self.SPOTS = SPOTS
        self.IMPRESIONES = IMPRESIONES
        self.INVERSION_LOCAL = INVERSION_LOCAL
        self.INVERSION_DOLARES = INVERSION_DOLARES

    def __repr__(self):
        return self.iddata_cpt


db.create_all()
db.session.commit()


class ETL_Diario_Schema(ma.Schema):
    class Meta:
        fields = (
            "iddata_cpt",
            "TIPO_REPORTE",
            "CLIENTE",
            "PAIS",
            "FECHA",
            "ANIO",
            "MES",
            "HORA",
            "SECTOR",
            "CATEGORIA",
            "ANUNCIANTE",
            "MARCA",
            "PRODUCTO",
            "VERSION",
            "CAMPANIA",
            "TIPO_MEDIO",
            "SUBTIPO_DE_MEDIO",
            "GRUPO_DE_MEDIOS",
            "MEDIO",
            "PROGRAMA",
            "FRANJA",
            "GENERO",
            "AVISO",
            "DISPOSITIVO",
            "TIPO",
            "AREA",
            "ANCHO",
            "ALTO",
            "ADSERVER",
            "AGENCIA",
            "DURACION",
            "SPOTS",
            "IMPRESIONES",
            "INVERSION_LOCAL",
            "INVERSION_DOLARES"
        )


etl_scehma = ETL_Diario_Schema()
etl_scehmas = ETL_Diario_Schema(many=True)


"""
Funciones de Usuarios (Login, register)
"""


@app.route(host + "/totales", methods=["GET"])
def get_totales():
    query_columns = [
        func.count(ETL_Diario.CLIENTE.distinct()),
        func.count(ETL_Diario.MEDIO.distinct()),
        func.count(ETL_Diario.MARCA.distinct()),
        func.count(ETL_Diario.CATEGORIA.distinct()),
        func.count(ETL_Diario.PRODUCTO.distinct()),
        func.count(ETL_Diario.ANUNCIANTE.distinct()),
        func.count(ETL_Diario.VERSION.distinct())
    ]

    clientes, medios, marcas, categorias, productos, anunciantes, versiones = db.session.query(
        *query_columns).first()

    datas = {
        "clientes": clientes,
        "marcas": marcas,
        "categorias": categorias,
        "productos": productos,
        "anunciantes": anunciantes,
        "version": versiones,
        "medios": medios
    }

    if any(datas.values()):
        return jsonify(datas), 200

    return "No hay resultados", 404


@app.route(host + "/", methods=["GET"])
def get_index():
        return jsonify("Sistema funcionando correctamente en el puerto 7000"), 200


@app.route(host + "/categorias", methods=["GET"])
def get_categorias():
    result = db.session.query(ETL_Diario.CATEGORIA.distinct()).all()
    categorias = [row[0] for row in result]

    if categorias:
        return jsonify(categorias), 200

    return "No hay resultados", 404


# Endpoint para obtener las categorías de manera paginada
@app.route('/categoriasx', methods=['GET'])
def get_categorias_paginadas():
    page = request.args.get('page', 1, type=int)
    per_page = 2  # Número de categorías por página

    # Calcular el índice de inicio y fin para la paginación
    start_idx = (page - 1) * per_page
    end_idx = start_idx + per_page

    # Consultar las categorías desde la base de datos
    result = db.session.query(ETL_Diario.CATEGORIA.distinct()).slice(
        start_idx, end_idx).all()
    print(db.session.query(ETL_Diario.CATEGORIA.distinct()))
    categorias = [row[0] for row in result]

    if categorias:
        return jsonify(categorias), 200

    return "No hay resultados", 404


@app.route(host + "/anunciantes", methods=["GET"])
def get_anunciantes():
    result = db.session.query(ETL_Diario.ANUNCIANTE.distinct()).all()
    anunciantes = [row[0] for row in result]

    if anunciantes:
        return jsonify(anunciantes), 200

    return "No hay resultados", 404


@app.route(host + "/marcas", methods=["GET"])
def get_marcas():
    result = db.session.query(ETL_Diario.MARCA.distinct()).all()
    marcas = [row[0] for row in result]
    if marcas:
        return jsonify(marcas), 200
    return "No hay resultados", 404


@app.route(host + "/clientes", methods=["GET"])
def get_clientes():
    result = db.session.query(ETL_Diario.CLIENTE.distinct()).all()
    clientes = [row[0] for row in result]
    if clientes:
        return jsonify(clientes), 200
    return "No hay resultados", 404


@app.route(host + "/productos", methods=["GET"])
def get_productos():
    result = db.session.query(ETL_Diario.PRODUCTO.distinct()).all()
    productos = [row[0] for row in result]
    if productos:
        return jsonify(productos), 200
    return "No hay resultados", 404


@app.route(host + "/version", methods=["GET"])
def get_version():
    result = db.session.query(ETL_Diario.VERSION.distinct()).all()
    version = [row[0] for row in result]
    if version:
        return jsonify(version), 200
    return "No hay resultados", 404


@app.route(host + "/tipomedio", methods=["GET"])
def get_tipomedio():
    result = db.session.query(ETL_Diario.TIPO_MEDIO.distinct()).all()
    tipomedio = [row[0] for row in result]
    if tipomedio:
        return jsonify(tipomedio), 200
    return "No hay resultados", 404


@app.route(host + "/medios", methods=["GET"])
def get_medios():
    result = db.session.query(ETL_Diario.MEDIO.distinct()).all()
    medios = [row[0] for row in result]
    if medios:
        return jsonify(medios), 200
    return "No hay resultados", 404


@app.route(host + "/etl", methods=["GET"])
def get_etl_diario():
    page = request.args.get("page", default=1, type=int)
    per_page = request.args.get("per_page", default=50, type=int)

    categoria = request.args.get("categoria", default="", type=str)
    anunciante = request.args.get("anunciante", default="", type=str)
    marca = request.args.get("marca", default="", type=str)
    producto = request.args.get("producto", default="", type=str)
    version = request.args.get("version", default="", type=str)
    tipomedio = request.args.get("tipodemedio", default="", type=str)
    medio = request.args.get("medio", default="", type=str)

    etl_diario_query = ETL_Diario.query

    if categoria:
        etl_diario_query = etl_diario_query.filter(
            ETL_Diario.CATEGORIA == categoria)

    if anunciante:
        etl_diario_query = etl_diario_query.filter(
            ETL_Diario.ANUNCIANTE == anunciante)

    if marca:
        etl_diario_query = etl_diario_query.filter(ETL_Diario.Marca == marca)

    if producto:
        etl_diario_query = etl_diario_query.filter(
            ETL_Diario.PRODUCTO == producto)

    if version:
        etl_diario_query = etl_diario_query.filter(
            ETL_Diario.VERSION == version)

    if tipomedio:
        etl_diario_query = etl_diario_query.filter(
            ETL_Diario.TIPO_MEDIO == tipomedio)

    if medio:
        etl_diario_query = etl_diario_query.filter(ETL_Diario.MEDIO == medio)

    etl_diario_pagination = etl_diario_query.paginate(
        page=page, per_page=per_page)

    etl_diario = etl_diario_pagination.items

    if etl_diario:
        return etl_scehmas.jsonify(etl_diario), 200

    return "No hay resultados", 404


@app.route(host + '/excel', methods=['POST'])
def generar_excel():
    data = request.form
    # Obtener los datos del cuerpo del POST
    categoria = data.get("categoria", "")
    anunciante = data.get("anunciante", "")
    marca = data.get("marca", "")
    producto = data.get("producto", "")
    version = data.get("version", "")
    tipomedio = data.get("tipodemedio", "")
    medio = data.get("medio", "")
    fecha_inicio = data.get("fecha_inicio", "")

    etl_diario_query = ETL_Diario.query

    if fecha_inicio:
        fecha_inicio = datetime.strptime(fecha_inicio, "%Y-%m-%d").date()
        fecha_mes = fecha_inicio.month
        fecha_anio = fecha_inicio.year
        etl_diario_query = etl_diario_query.filter(
            (ETL_Diario.MES == fecha_mes) &
            (ETL_Diario.ANIO == fecha_anio)
        )

    if categoria:
        etl_diario_query = etl_diario_query.filter(
            ETL_Diario.CATEGORIA == categoria)

    if anunciante:
        etl_diario_query = etl_diario_query.filter(
            ETL_Diario.ANUNCIANTE == anunciante)

    if marca:
        etl_diario_query = etl_diario_query.filter(ETL_Diario.MARCA == marca)

    if producto:
        etl_diario_query = etl_diario_query.filter(
            ETL_Diario.PRODUCTO == producto)

    if version:
        etl_diario_query = etl_diario_query.filter(
            ETL_Diario.VERSION == version)

    if tipomedio:
        etl_diario_query = etl_diario_query.filter(
            ETL_Diario.TIPO_MEDIO == tipomedio)

    if medio:
        etl_diario_query = etl_diario_query.filter(ETL_Diario.MEDIO == medio)

    results = etl_diario_query.all()  # Obtener todos los resultados



    if results:
        headers = ['ADSERVER', 'AGENCIA', 'ALTO', 'ANCHO', 'ANIO', 'ANUNCIANTE', 'AREA', 'AVISO', 'CAMPANIA', 'CATEGORIA',
        'CLIENTE', 'DateInsert', 'DISPOSITIVO', 'DURACION', 'FECHA', 'FRANJA', 'GENERO', 'GRUPO_DE_MEDIOS', 'HORA',
        'iddata_cpt', 'IMPRESIONES', 'INVERSION_DOLARES', 'INVERSION_LOCAL', 'LINK', 'MARCA', 'MEDIO', 'MES', 'PAIS',
        'PRODUCTO', 'PROGRAMA', 'SECTOR', 'SPOTS', 'SUBTIPO_DE_MEDIO', 'TIPO', 'TIPO_MEDIO', 'TIPO_REPORTE', 'Total_AMAS', 'VERSION',
        'Total_H18a60', 'Total_H18a60Al_Me', 'Total_H18a99Al_Me', 'Total_H25a39', 'Total_H25a60', 'Total_H25a60Al_Me',
        'Total_H25a60Baja', 'Total_H40a60', 'Total_HyM12a24Al_Me', 'Total_HyM12a60', 'Total_HyM12a99', 'Total_HyM18a39',
        'Total_HyM18a39Al_Me', 'Total_HyM18a39Baja', 'Total_HyM18a60', 'Total_HyM18a60Al_Me', 'Total_HyM18a60Baja',
        'Total_HyM18a99', 'Total_HyM25a39', 'Total_HyM25a39Al_Me', 'Total_HyM25a39Baja', 'Total_HyM25a60',
        'Total_HyM25a60Al_Me', 'Total_HyM25a99', 'Total_HyM25a99Al_Me', 'Total_HyM25a99Baja', 'Total_HyM3a99Total',
        'Total_HyM40a60Al_Me', 'Total_M18a39', 'Total_M18a39Al_Me', 'Total_M18a39Baja', 'Total_M18a60', 'Total_M18a60Baja',
        'Total_M25a39', 'Total_M25a60', 'Total_M25a60Baja']

        excel_data = BytesIO()
        wb = xlsxwriter.Workbook(excel_data, {'in_memory': True})
        ws = wb.add_worksheet()

        # Agregar encabezados
        for col, header in enumerate(headers):
            ws.write(0, col, header)

        for row, result in enumerate(results, start=1):
            for col, field in enumerate(headers):
                if field == 'FECHA' or field == "DateInsert":
                    fecha = getattr(result, field, '')
                    ws.write(row, col, str(fecha))
                else:
                    ws.write(row, col, getattr(result, field, ''))
        wb.close()
        del wb
        excel_data.seek(0)
        nombre_final = "competencia_" + \
            str(datetime.now().strftime("%Y-%m-%d"))

        response = make_response(
            send_file(excel_data, download_name=nombre_final+'.xlsx', as_attachment=True))
        response.status_code = 200
        return response
    return "No hay resultados", 404


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=7000)
    #app.run(host='0.0.0.0', debug=True, port=7000)
