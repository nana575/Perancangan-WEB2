print("Caculator Python")
print("----------------")

print("1. Penjumlahan")
print("2. Pengurangan")
print("3. Perkalian")
print("4. Pembagian")
print("----------------")

#logic
def penjumlahan(x,y):
    return x+y

def pengurangan(x,y):
    return x-y

def perkalian(x,y):
    return x*y

def pembagian(x,y):
    return x/y

tipe = input("Silakan masukan nomor yang kalian pilih :")

if tipe in ('1', '2','3', '4'):
    angka1 = float(input("angka pertama :"))
    angka2 = float(input("angka kedua :"))
    print("----------------")
    if tipe == '1':
        print("Jawabannya adalah :", penjumlahan(angka1, angka2))
    if tipe == '2':
        print("Jawabannya adalah :", pengurangan(angka1, angka2))
    if tipe == '3':
        print("Jawabannya adalah :", perkalian(angka1, angka2))
    if tipe == '4':
        print("Jawabannya adalah :", pembagian(angka1, angka2))
    print("----------------")