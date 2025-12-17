# Program Manajemen Data Buku Sederhana

data_buku = []

def menu():
    print("========= MENU =========")
    print("[1] Masukkan Data Buku")
    print("[2] Tampilkan Data Buku")
    print("[3] Cari Buku")
    print("[4] Update Data Buku")
    print("[5] Hapus Buku")
    print("[6] Hapus Semua Data Buku")
    print("[7] Exit")

while True:
    menu()
    pilihan = input("Pilih menu: ")

    # 1. INPUT DATA BUKU
    if pilihan == "1":
        while True:
            judul = input("\nMasukkan Judul Buku: ")
            data_buku.append(judul)
            print(f"Buku '{judul}' : Berhasil ditambahkan")
            
            lagi = input("Mau isi lagi? (y/t): ").lower()
            if lagi != 'y':
                break
        
        input("\nTekan Enter untuk kembali...")

    # 2. TAMPILKAN DATA BUKU
    elif pilihan == "2":
        print("\n===== DATA BUKU =====")
        if len(data_buku) == 0:
            print("Belum ada data.")
        else:
            for i, b in enumerate(data_buku, start=1):
                print(f"{i}. {b}")
        input("\nTekan Enter untuk kembali...")

    # 3. CARI BUKU
    elif pilihan == "3":
        cari = input("Masukkan judul yang dicari: ")
        if cari in data_buku:
            print(f"Buku ditemukan: {cari}")
        else:
            print("Buku tidak ditemukan.")
        input("\nTekan Enter untuk kembali...")

    # 4. UPDATE DATA BUKU
    elif pilihan == "4":
        print("\n===== UPDATE BUKU =====")
        for i, b in enumerate(data_buku, start=1):
            print(f"{i}. {b}")
        
        idx = int(input("Pilih nomor buku yang ingin di-update: "))
        if 1 <= idx <= len(data_buku):
            baru = input("Masukkan judul baru: ")
            data_buku[idx-1] = baru
            print("Data berhasil di-update.")
        else:
            print("Nomor tidak valid.")
        input("\nTekan Enter untuk kembali...")

    # 5. HAPUS BUKU
    elif pilihan == "5":
        hapus = input("Masukkan judul buku yang ingin dihapus: ")
        if hapus in data_buku:
            data_buku.remove(hapus)
            print("Buku berhasil dihapus.")
        else:
            print("Buku tidak ditemukan.")
        input("\nTekan Enter untuk kembali...")

    # 6. HAPUS SEMUA
    elif pilihan == "6":
        yakin = input("Yakin ingin hapus semua? (y/t): ").lower()
        if yakin == "y":
            data_buku.clear()
            print("Semua data berhasil dihapus.")
        else:
            print("Dibatalkan.")
        input("\nTekan Enter untuk kembali...")

    # 7. EXIT
    elif pilihan == "7":
        print("Program selesai.")
        break

    else:
        print("Pilihan tidak valid, coba lagi!")
