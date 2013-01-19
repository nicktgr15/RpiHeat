#include <wiringPi.h>

#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>

#include <softPwm.h>

int main (int argc, char *argv[])
{
  int pin ;
  int l ;

  printf ("Raspberry Pi wiringPi PWM test program\n") ;

  if (wiringPiSetup () == -1)
    exit (1) ;

 // for (pin = 0 ; pin < 1 ; ++pin)
 // {
    pinMode (0, OUTPUT) ;
    digitalWrite (0, LOW) ;

 //}

  softPwmCreate(0,0,200);
  int a=50;
  l=150;

//  for(l=182;l<=192;l=l+2){
 // for(;;){
  int pos=atoi(argv[1]);
  if(pos<180) pos=180;
  if(pos>194) pos=194;
  softPwmWrite(0,pos);
//printf('%d',(int)(argv[1]));

 // }
  delay(1000);
 // if(l==192)l=182;
 // }
  //
  return 0 ;
}
