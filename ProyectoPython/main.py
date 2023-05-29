import cv2
import pickle
import cvzone
import numpy as np
import time
import pymysql
from datetime import datetime
import time

Connection = pymysql.connect(
    host="localhost",
    user="root",
    password="",
    db="fadama")
cursor = Connection.cursor()

posListArea = []
posArea = []
spaceCounterArea = []

# Camara de area
#cv2.namedWindow('video que muestra el Area', cv2.WINDOW_NORMAL)
#cv2.resizeWindow('video que muestra el Area', 800,600)
cap2 = cv2.VideoCapture('estacionamiento.mp4')
insert = 0
with open('CarParkPosCar', 'rb') as g:
    posListArea = pickle.load(g)

width2, height2 = 60, 50


def checkParkingSpaceArea(imgProArea, insert):  # Vereficar los espacios disponibles
    spaceCounterArea = 0
    i = 1

    for posArea in posListArea:

        x, y = posArea  # Verificar si hay un automovil dentro del estacionamiento
        imgCrop2 = imgProArea[y:y + height2, x:x + width2]
        # cv2.imshow(str(x * y), imgCrop)
        countArea = cv2.countNonZero(imgCrop2)

        if countArea < 300:  # Si un lugar del estacionamiento tiene un valor mayor a 900 lo va a marcar como ocupado
            color = (0, 255, 0)
            thickness = 5
            spaceCounterArea += 1
            # print(f"Numero de Estacionamiento vacio:{i} -> {len(posListArea)}")
            # print(f"Posicion : {posArea}")
            i += 1
        else:
            color = (0, 0, 255)
            thickness = 2
            # print(f"Numero de Estacionamiento ocupado:{i} -> {len(posListArea)}")
            # print(f"Posicion : {posArea}")
            i += 1

        cv2.rectangle(img2, posArea, (posArea[0] + width2, posArea[1] + height2), color, thickness)
        cvzone.putTextRect(img2, str(countArea), (x, y + height2 - 3), scale=1, thickness=2, offset=0, colorR=color)

    # Conteo de los carros en el estacionamiento
    cvzone.putTextRect(img2, f'Areas desocupadas: {spaceCounterArea}/{len(posListArea)}', (90, 50), scale=3,
                       thickness=5, offset=15, colorR=(0, 200, 0))
    if insert == 1:
        insert = 0
        print("se realiso el envio de datos")
        fecha = datetime.now()
        sql = "insert into parking(fecha,esocupados,estotal) values('{}','{}','{}')".format(fecha, spaceCounterArea,
                                                                                            len(posListArea))
        # ejecución
        cursor.execute(sql)
        # registra el cambio
        Connection.commit()


while True:
    # Duración del ciclo en segundos (30 segundos)
    duration = 20

    # Tiempo inicial
    start_time = time.time()

    # Tiempo final (tiempo inicial + duración)
    end_time = start_time + duration

    # Ciclo que se ejecuta durante 30 segundos
    while time.time() < end_time:
        insert = 0
        # Código a ejecutar en cada iteración
        if cap2.get(cv2.CAP_PROP_POS_FRAMES) == cap2.get(
                cv2.CAP_PROP_FRAME_COUNT):  # Total de cuadros que tenemos en el video
            cap2.set(cv2.CAP_PROP_POS_FRAMES, 0)
        success, img2 = cap2.read()
        imgGray2 = cv2.cvtColor(img2, cv2.COLOR_BGR2GRAY)
        imgBlur2 = cv2.GaussianBlur(imgGray2, (3, 3), 1)  # Dimension de los espacios y asignar el valor
        imgThreshold2 = cv2.adaptiveThreshold(imgBlur2, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C,
                                              cv2.THRESH_BINARY_INV, 25, 16)
        imgMedian2 = cv2.medianBlur(imgThreshold2, 5)
        kernel2 = np.ones((3, 3), np.uint8)
        imgDilate2 = cv2.dilate(imgMedian2, kernel2, iterations=1)

        checkParkingSpaceArea(imgDilate2, insert)
        cv2.imshow('video que muestra el Area', img2)
        # cv2.imshow("ImageBlur", imgBlur)  #Convertir el video en blanco y negro
        # cv2.imshow("ImageThres", imgMedian)   #Convertir el video en neutro
        cv2.waitKey(10)
    insert = insert + 1
    checkParkingSpaceArea(imgDilate2, insert)

    # Hacer una pausa de 1 segundo en cada iteración
    # Area de carro