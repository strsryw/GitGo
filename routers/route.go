package routers

import (
	"net/http"
	"warmingup/controllers"
)

func init() {
	http.HandleFunc("/bernofarm", controllers.DashboardController)

	http.Handle("/static/",
		http.StripPrefix("/static/",
			http.FileServer(http.Dir("static"))))
}
