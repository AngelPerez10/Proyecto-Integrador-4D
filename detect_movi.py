
import cv2
import numpy as np
"""
cap = cv2.VideoCapture('videopers.mp4')
#sustraccion de fondo en blanco los que están en movimiento
fgbg = cv2.bgsegm.createBackgroundSubtractorMOG()
#kernel para mejorar la imagen binaria
kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE,(3,3))
while True:
    ret,img = cap.read()
    if ret == False: break

        #transforma de bgr a escala de grises
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

    #Dibujamos un rectangulo en frame, para señalar el estado
    #del área en análisis (movimiento detectado o no detectado)
    cv2.rectangle(img,(0,0),(img.shape[1],40),(0,0,0), 1 )
    color = (0,255,0)
    texto_estado = "Estado: no se ha detectado movimiento"

    #especificamos los puntos extremos a detectar
    area = np.array([[240,320], [480,320], [620,img.shape[0]],[0,img.shape[0]]])

    #visualizamos el alrededor del áre que vamos analizar
    cv2.drawContours(img,[area], -1,color,2)

    #visualizar el esatado de la deteccion en movimiento
    cv2.putText(img, texto_estado, (10,30),cv2.FONT_HERSHEY_SIMPLEX,1,color,2)


    cv2.imshow('frame', img)

    if cv2.waitKey(1) & 0xFF == ord('q'):
        break
    cap.release()
    cv2.destroyAllWindows()
"""

cap = cv2.VideoCapture(0)
fgbg = cv2.bgsegm.createBackgroundSubtractorMOG()
kernel =  cv2.getStructuringElement(cv2.MORPH_ELLIPSE,(3,3))

while True:
    ret, frame = cap.read()
    if ret == False: break
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    area_pts = np.array([[200,290], [350,290],[350,450],[200,450]])
    imAux = np.zeros(shape=(frame.shape[:2]), dtype =np.uint8)
    imAux = cv2.drawContours(imAux, [area_pts,], -1, (255), -1)
    image_area = cv2.bitwise_and(gray, gray, mask=imAux)
    fgmask = fgbg.apply(image_area)
    fgmask = cv2.morphologyEx(fgmask, cv2.MORPH_OPEN, kernel)
    fgmask = cv2.dilate(fgmask, None, iterations=2)
    cnts = cv2.findContours(fgmask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)[0]
    for cnt in cnts:
        if cv2.contourArea(cnt) > 500:
            x,y,w,h = cv2.boundingRect(cnt)
            cv2.rectangle(frame, (x,y), (x+w,y+h), (255,0,0),2)
            color = (0,0, 255)
    color = (0,255,0)
    cv2.drawContours(frame, [area_pts], -1, color, 2)
    cv2.imshow("frame", frame)
    cv2.imshow("fgmask",fgmask)
    k = cv2.waitKey(1) & 0xFF
    if k == 27:
        break
cap.release()
cv2.destroyAllWindows()
