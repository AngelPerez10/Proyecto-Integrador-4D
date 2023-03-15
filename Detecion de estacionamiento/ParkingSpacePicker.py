#Selector de espacios de estacionamiento

import cv2
import pickle

width, height = 230, 150

try:
    with open('CarParkPos', 'rb') as f: #Sirve para guardar los rectangulos de la imagen anterior
        posList = pickle.load(f)
except:
    posList = []    #Lista de posiciones


def mouseClick(events, x, y, flags, params):
    if events == cv2.EVENT_LBUTTONDOWN:
        posList.append((x, y))      #Sirve para crear una nueva lista en el postList de x,y
    if events == cv2.EVENT_RBUTTONDOWN:
        for i, pos in enumerate(posList):
            x1, y1 = pos
            if x1 < x < x1 + width and y1 < y < y1 + height:
                posList.pop(i)      #Sirve para eliminar la lista de posicion en el postList de x,y

    with open('CarParkPos', 'wb') as f:     #Sirve para guardar los rectangulos en la imgane
        pickle.dump(posList, f)


while True:
    img = cv2.imread('estacionamiento.png')
    for pos in posList:
        cv2.rectangle(img, pos, (pos[0] + width, pos[1] + height), (255, 0, 255), 2)    #Creamos el rectangulo del estacionamiento

    cv2.imshow("Image", img)
    cv2.setMouseCallback("Image", mouseClick)   #Detectar el click del mouse
    cv2.waitKey(1)