package main

import (
	"github.com/gin-gonic/gin"
	"io"
	"net/http"
)

func upload_image(c *gin.Context) {
	//Source
	fileheader, err := c.FormFile("file")
	if err != nil {
		c.String(http.StatusBadRequest, "get form err: %s", err.Error())
		return
	}

	file, err := fileheader.Open()
	if err != nil {
		c.String(http.StatusBadRequest, "File can't open: %s", err.Error())
	}
	defer file.Close()

	buffer, err := io.ReadAll(file)
	if err != nil {
		c.String(http.StatusBadRequest, "File can't ReadAll(): %s", err.Error())
	}

	errDir := createFolder("uploads")
	if errDir != nil {
		panic(errDir)
	}

	fn02, err := imageProcessing(buffer, 0.2, "uploads")
	if err != nil {
		panic(err)
	}
	fn10, err := imageProcessing(buffer, 10, "uploads")
	if err != nil {
		panic(err)
	}
	fn40, err := imageProcessing(buffer, 40, "uploads")
	if err != nil {
		panic(err)
	}
	fn80, err := imageProcessing(buffer, 80, "uploads")
	if err != nil {
		panic(err)
	}

	c.JSON(http.StatusOK, gin.H{
		"picture_0.2": "http://localhost:8080/uploads/" + fn02,
		"picture_10": "http://localhost:8080/uploads/" + fn10,
		"picture_40": "http://localhost:8080/uploads/" + fn40,
		"picture_80": "http://localhost:8080/uploads/" + fn80,
	})
}
