package main

import (
	_ "fmt"
	"github.com/gin-gonic/gin"
	_ "path/filepath"
)

func main() {
	router := gin.Default()
	router.MaxMultipartMemory = 8 << 20
	router.POST("/upload_image", upload_image)
	router.POST("/upload_voice", upload_voice)
	router.Run(":8080")
}
