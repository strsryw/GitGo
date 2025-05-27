package main

import (
	"fmt"
	"log"
	"net/http"
	"warmingup/config"
	_ "warmingup/routers"
)

func main() {
	config.ConnectDB()
	port := ":9090"
	fmt.Println("Server berjalan di http://localhost" + port)
	log.Fatal(http.ListenAndServe(port, nil))
}
