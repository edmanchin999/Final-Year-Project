
//IR temperature
#include <Wire.h>
#include <Adafruit_MLX90614.h>
#include <LiquidCrystal_I2C.h>
#define trigPin 2
#define echoPin 3    
LiquidCrystal_I2C lcd(0x27,16,2);
Adafruit_MLX90614 mlx = Adafruit_MLX90614();
const byte SIMBOLDERAJAT = B11011111;
#include <SoftwareSerial.h>
SoftwareSerial ArduinoUno(11,12);

//Motion Sensor
int relayPin = 9;                // choose the pin for the Relay
int pirPin = 8;               // choose the input pin (for PIR sensor)
int pirState = LOW;             // we start, assuming no motion detected
int val = 0;




//water level
#define Trigger_Pin 7
#define Echo_Pin 6
#define UltraSonic_Div 0.034
long duration;
  float distance;
  float percentage;

void setup()
{
  //IR temperature
  lcd.init();                  
  lcd.backlight();
  lcd.clear(); 
  mlx.begin();
  Serial.begin(9600);

  //Motion Sensor
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  pinMode(relayPin, OUTPUT);      // declare LED as output
  pinMode(pirPin, INPUT);     // declare sensor as input
  Serial.begin(9600);

  //water level
   Serial.begin(9600);
  //Initialise Echo Input & Trigger Output
  pinMode(Echo_Pin,INPUT);
  pinMode(Trigger_Pin,OUTPUT);
  //Reset the trigger pin and wait for half a second 
  //Need to change for half a second to half an hour during implementation
  digitalWrite(Trigger_Pin,LOW);
  delayMicroseconds(500);

  //Serial Communication
  Serial.begin(9600);
  ArduinoUno.begin(4800);

  
}
 
void loop()
{
  
Temperature();
MotionSensor(); 
WaterLevel();
finalOutput();
 
}
void Temperature(){
  
  //Tampilkan di serial monitor untuk suhu
  //Serial.print("Object = ");
  //Serial.print(mlx.readObjectTempC()/1.4);
  //Serial.println("*C");
  
  
  float tempDuration, tempDistance;
  digitalWrite(trigPin, LOW); 
  delayMicroseconds(2);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(6);
  digitalWrite(trigPin, LOW);
  tempDuration = pulseIn(echoPin, HIGH);
  tempDistance = (tempDuration/2) / 29.1;
  //Serial.print("TempDistance ");
  //Serial.print(tempDistance);
  //Serial.println(" cm");
  delay(1000);
   
  //Apabila Jarak dibawah 8 cm dan suhu >37 celcius
  if (tempDistance < 8){
  if(mlx.readObjectTempC()/1.4 > 37)
  
  {
    
    
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("--ANDA DEMAM --");
    lcd.setCursor(0, 1);
    lcd.print("Suhu: ");
    lcd.setCursor(7, 1);
    lcd.print(mlx.readObjectTempC()/1.4); //*1.125 (UNTUK PENGALI KALIBRASI)
    lcd.setCursor(12, 1);
    lcd.write(SIMBOLDERAJAT);
    lcd.setCursor(13, 1);
    lcd.print("C");
   

    delay(1000);
    
  }
  }

  //Apabila Jarak dibawah 8 cm dan suhu <37 celcius
  if (tempDistance < 8){
  if(mlx.readObjectTempC()/1.4 < 37)
   {
    
    
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("--ANDA SIHAT --");
    lcd.setCursor(0, 1);
    lcd.print("Suhu: ");
    lcd.setCursor(7, 1);
    lcd.print(mlx.readObjectTempC()/1.4);  //*1.128 (UNTUK PENGALI KALIBRASI) Nilai ini bisa dikosongkan
    lcd.setCursor(12, 1);
    lcd.write(SIMBOLDERAJAT);
    lcd.setCursor(13, 1);
    lcd.print("C");
    

    delay(1000);
    
  }
  }

  
   if (tempDistance > 8) {
    delay(100);
    lcd.clear();
    lcd.setCursor(3, 0);
    lcd.print("Sila dekat");
    lcd.setCursor(4, 1);
    lcd.print("Lagi <3");
    delay(1000);
    }
  }
  void WaterLevel(){
  ///defined required variable
  

  //Measure: Put up Trigger...
  digitalWrite(Trigger_Pin,HIGH);
  //wait for 11 ms
  delayMicroseconds(11);
  //Meaure: Put down Trigger
  digitalWrite(Trigger_Pin,LOW);
  //Then wait for the echo to calculate the duration in order to count the distance
  duration = pulseIn(Echo_Pin,HIGH);
  distance = ((float)duration*0.034 )/2  ;
  percentage = map(distance , 18,2,0,100);
  //percentage = map(distance, 20,4,0,100);
  //Serial.print("Water Level %: ");
  //Serial.print(percentage);
  //Serial.print(" %");
  

  delay(2000);
 }

    
void MotionSensor(){
  val = digitalRead(pirPin);  // read input value
  if (val == HIGH) {            // check if the input is HIGH
    digitalWrite(relayPin, HIGH);  // turn RElay ON
    if (pirState == LOW) {
      // we have just turned on
      Serial.println("Motion detected!");
      // We only want to print on the output change, not state
      pirState = HIGH;
    }
  } else {
    digitalWrite(relayPin, LOW); // turn Relay OFF
    if (pirState == HIGH){
      // we have just turned of
      Serial.println("Motion ended!");
      // We only want to print on the output change, not state
      pirState = LOW;
    }
  }
  
 }

 void finalOutput(){
  Serial.print('<'); // start marker
Serial.print(percentage);
Serial.print(','); // comma separator
Serial.print(mlx.readObjectTempC()/1.4);
Serial.println('>'); // end marker
 }
 

      
