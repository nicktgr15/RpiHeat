#include <stdio.h>
#include <stdlib.h>
#include <linux/i2c-dev.h>
#include <fcntl.h>
#include <string.h>
#include <sys/ioctl.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <unistd.h>

void setSpeed(unsigned char speed);
void setAcceleration(void);
void driveMotor(void);

int fd;														// File descrition
char *fileName = "/dev/i2c-1";								// Name of the port we will be using
int  address = 0x31;										// Address of MD03 shifted one bit right
unsigned char buf[10];										// Buffer for data being read/ written on the i2c bus
	
int main(int argc, char **argv)
{
	//printf("**** MD03 test program ****\n");
	
	
	
	if ((fd = open(fileName, O_RDWR)) < 0) {					// Open port for reading and writing
		printf("Failed to open i2c port\n");
		exit(1);
	}
	
	if (ioctl(fd, I2C_SLAVE, address) < 0) {					// Set the port options and set the address of the device we wish to speak to
		printf("Unable to get bus access to talk to slave\n");
		exit(1);
	}
	
	/*buf[0] = 160;													// This is the register we wish to read software version from
	
	if ((write(fd, buf, 1)) != 1) {								// Send regiter to read from
		printf("Error writing to i2c slave\n");
		exit(1);
	}
	
	if (read(fd, buf, 3) != 3) {								// Read back data into buf[]
		printf("Unable to read from slave\n");
		exit(1);
	}
	else {
		printf("Software v: %u %u %u\n",buf[0],buf[1],buf[2]);
	}*/
	
	buf[0] = 1;													// register that stores the speed the motor is to be set to
	buf[1] = 0;												// Sepped to be set
	
	if ((write(fd, buf, 2)) != 2) {			
		printf("Error writing to i2c slave\n");
		exit(1);
	}
	
	buf[0] = 2;													// register that stores the speed the motor is to be set to

	if ((write(fd, buf, 1)) != 1) {			
		printf("Error writing to i2c slave\n");
		exit(1);
	}
	
	buf[0] = 4;													// This is the register we wish to read software version from
	
	if ((write(fd, buf, 1)) != 1) {								// Send regiter to read from
		printf("Error writing to i2c slave\n");
		exit(1);
	}
	
	if (read(fd, buf, 2) != 2) {								// Read back data into buf[]
		printf("Unable to read from slave\n");
		exit(1);
	}
	
	
	
	else {
	unsigned short packedword;

	packedword = (buf[0] <<8) | buf[1];
		printf("%i\n",packedword);
	}
	
	
}