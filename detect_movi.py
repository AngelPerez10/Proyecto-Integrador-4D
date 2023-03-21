
import cv2
import numpy as np

cap = cv2.VideoCapture('estacionamiento.mp4')
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
