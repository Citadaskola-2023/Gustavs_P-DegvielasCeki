## **Fuel receipt data storage**

### **Description**

Data storage of fuel receipts for easy overview.

### **Requirements**

 - [Git](https://git-scm.com/)
 - [Docker](https://www.docker.com/get-started/)


### **Getting started**


  - Clone `git@github.com:Citadaskola-2023/Gustavs_P-DegvielasCeki.git` repository to your local machine using Git (read-only).
  - Install project dependencies using Composer.
    `docker run --rm --interactive --tty \
    --volume /$PWD:/app \
    composer install`
  - Start the PHP and mysql containers.
    `docker compose up -d`

### **License**

This project is licensed under the Unlicense - see the [LICENSE](https://github.com/Citadaskola-2023/Gustavs_P-DegvielasCeki/blob/main/LICENSE) file for details.
