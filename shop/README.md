# November 2015 works

> A flea market or swap meet is a type of bazaar where inexpensive or secondhand goods are sold or bartered

![image](screenshot/create.gif "发布商品")
![image](screenshot/market1.gif "大体展示")

## Installation

1. Clone
    ```bash
   git clone https://github.com/frehaiku/Past-Work.git
    ```
2. Modify the db config(`Application/Home/Conf/config.php`)
    ```php
    <?php
    return array(
        'DB_TYPE'               =>  'MySql',
        'DB_HOST'               =>  '',             
        'DB_NAME'               =>  'root',
        'DB_USER'               =>  '123',
        'DB_PWD'                =>  'psd',
        'DB_PORT'               =>  '',
        'DB_PREFIX'             =>  'goods',
    );
    ```
3. insert `.sql` to your database