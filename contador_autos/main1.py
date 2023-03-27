import cv2
import math

# Inicializar la lista de coordenadas de carros detectados
car_coordinates = []

# Crear un detector de automóviles utilizando el archivo haarcascade
car_cascade = cv2.CascadeClassifier('cars.xml')

# Abrir el archivo de video
cap = cv2.VideoCapture('WhatsApp Video 2023-03-14 at 15.10.44.mp4')

while cap.isOpened():
    # Leer cada cuadro de video
    ret, frame = cap.read()

    if ret == True:
        # Convertir el cuadro a escala de grises
        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

        # Detectar automóviles en el cuadro
        cars = car_cascade.detectMultiScale(gray, 1.1, 15)

        # Actualizar la lista de coordenadas de carros detectados
        current_car_coordinates = []
        for (x, y, w, h) in cars:
            current_car_coordinates.append((x, y, w, h))

        # Dibujar el rectángulo alrededor de cada automóvil
        for (x, y, w, h) in car_coordinates:
            cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 250, 0), 10)

        for (x, y, w, h) in current_car_coordinates:
            car_detected = True
            for (cx, cy, cw, ch) in car_coordinates:
                distance = math.sqrt((x - cx) ** 2 + (y - cy) ** 2)
                if distance < cw:
                    car_detected = False
                    break
            if car_detected:
                # Dibujar el rectángulo alrededor del automóvil actual
                cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 250, 0), 10)

                # Agregar la coordenada del automóvil a la lista
                car_coordinates.append((x, y, w, h))

                print("Car detected!")

        # Escribir el número de carros detectados en la imagen
        cv2.putText(frame, f"Total cars: {len(car_coordinates)}", (20, 40),
                    cv2.FONT_HERSHEY_SIMPLEX, 1, (10, 10, 255), 2)

        # Mostrar el video con los rectángulos dibujados
        cv2.imshow('Car Counter', frame)

        # Salir del bucle si se presiona la tecla 'q'
        if cv2.waitKey(25) & 0xFF == ord('q'):
            break
    else:
        break

# Liberar el archivo de video y cerrar las ventanas
cap.release()
cv2.destroyAllWindows()

# Imprimir el número total de automóviles detectados
print('Total cars detected:', len(car_coordinates))
