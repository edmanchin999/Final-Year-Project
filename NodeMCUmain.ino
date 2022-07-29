#include <ESP8266WiFi.h>
#include <SoftwareSerial.h>

SoftwareSerial NodeMCU(D1,D2); //Rx, Tx pins

// Network ID
const char* ssid     = "eddiechin999@unifi";
const char* password = "qwerasdf";
//const char* host = "103.219.237.26";
const char* host = "lrgs.ftsm.ukm.my";
const int port = 80;


// Current time
unsigned long currentTime = millis();
// Previous time
unsigned long previousTime = 0; 
// Define timeout time in milliseconds (example: 2000ms = 2s)
const long timeoutTime = 2000;

//Testing variable
int testValue = 0;


boolean newData = false;

//============

void setup() {
    Serial.begin(115200); 
    NodeMCU.begin(9600);
    

  // Networking
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected.");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());

}

//============

void loop() {
  
  WiFiClient client;
  if (!client.connect(host, port)) {
    Serial.println("Connection failed");
    
    return;
  }

  //read the message from the serial
  String msg = NodeMCU.readString();
  String waterLevelPercentage = msg.substring(1,5);
  String temperature = msg.substring(7,11);
  Serial.println(waterLevelPercentage);
  Serial.println(temperature);

  // nodemcuphp/index.php?mode=save&temperature=${temp}&humidity=${humid}
  String apiUrl = "/users/a175894/fyp/DB_index.php?";
  apiUrl += "mode=save";
  apiUrl += "&waterLevelPercentage="+String(waterLevelPercentage);
  apiUrl += "&temperature="+String(temperature);

  // Set header Request
  client.print(String("GET ") + apiUrl + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" +
               "Connection: close\r\n\r\n");

  

  // Pastikan tidak berlarut-larut
  unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 3000) {
      Serial.println(">>> Client Timeout !");
      Serial.println(">>> Operation failed !");   
      client.stop();
      return;
    }
  }

  // Baca hasil balasan dari PHP
  while (client.available()) {
    String line = client.readStringUntil('\r');
    Serial.println(line);
   
  }
  
}








  
   
