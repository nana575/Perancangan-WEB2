import cv2
import time
import random
import numpy as np

# =========================
# Load Haar Cascade
# =========================
face_cascade = cv2.CascadeClassifier(
    cv2.data.haarcascades + "haarcascade_frontalface_default.xml"
)
smile_cascade = cv2.CascadeClassifier(
    cv2.data.haarcascades + "haarcascade_smile.xml"
)

# =========================
# Buka Kamera
# =========================
cam = cv2.VideoCapture(0, cv2.CAP_DSHOW)
if not cam.isOpened():
    print("Kamera tidak bisa dibuka")
    exit()

# =========================
# Variabel Kontrol
# =========================
no_smile_start_time = None
question_shown = False

questions = [
    "Kenapa kamu tidak senyum hari ini?",
    "Ada sesuatu yang mengganggu pikiranmu?",
    "Hari ini terasa berat?",
    "Kamu baik-baik saja?",
    "Butuh waktu istirahat?"
]

print("Program berjalan. Tekan Q untuk keluar.")

# =========================
# Loop Utama
# =========================
while True:
    ret, frame = cam.read()
    if not ret:
        break

    frame = cv2.flip(frame, 1)
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

    faces = face_cascade.detectMultiScale(gray, 1.3, 5)

    for (x, y, w, h) in faces:
        cv2.rectangle(frame, (x, y), (x + w, y + h), (255, 0, 0), 2)

        text_x = x
        text_y = y + h + 30

        face_gray = gray[y:y + h, x:x + w]
        smiles = smile_cascade.detectMultiScale(face_gray, 1.7, 20)

        # =========================
        # Jika SENYUM
        # =========================
        if len(smiles) > 0:
            no_smile_start_time = None
            question_shown = False

            cv2.putText(
                frame,
                "SENYUM",
                (text_x, text_y),
                cv2.FONT_HERSHEY_SIMPLEX,
                0.8,
                (0, 255, 0),
                2
            )

        # =========================
        # Jika TIDAK SENYUM
        # =========================
        else:
            if no_smile_start_time is None:
                no_smile_start_time = time.time()

            elapsed = time.time() - no_smile_start_time

            cv2.putText(
                frame,
                "TIDAK SENYUM",
                (text_x, text_y),
                cv2.FONT_HERSHEY_SIMPLEX,
                0.8,
                (0, 0, 255),
                2
            )

            # Tampilkan pertanyaan setelah 3 detik
            if elapsed >= 3 and not question_shown:
                question = random.choice(questions)

                cv2.putText(
                    frame,
                    question,
                    (x, y - 20),
                    cv2.FONT_HERSHEY_SIMPLEX,
                    0.7,
                    (255, 255, 255),
                    2
                )

                question_shown = True

    # =========================
    # Tampilkan Frame
    # =========================
    cv2.imshow("Smile Detection", frame)

    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# =========================
# Tutup Program
# =========================
cam.release()
cv2.destroyAllWindows()
