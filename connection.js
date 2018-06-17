const Sequelize = require('sequelize');
const Cron = require('cron');

function reset() {
    const sqz = new Sequelize("kuliahku", "root", "", {
        host: "localhost",
        dialect: 'mysql',
        operatorsAliases: false,

        pool: {
            max: 5,
            min: 0,
            acquire: 30000,
            idle: 10000
        },
    })

    const KuliahTemp = sqz.define('kuliahTemp', {
        idKuliah: {
            primaryKey: true,
            type: Sequelize.STRING
        },
        idMatkul: Sequelize.STRING,
        hari: Sequelize.STRING,
        jam: Sequelize.TIME,
        idDosen: Sequelize.STRING,
        idTugas: {
            type: Sequelize.STRING,
            allowNull: true
        },
        status: Sequelize.STRING,
        isTemp: Sequelize.INTEGER,
    }, {
            timestamps: false,
            underscored: false,
            tableName: "kuliahTemp"
        })

    const Kuliah = sqz.define('kuliah', {
        idKuliah: {
            primaryKey: true,
            type: Sequelize.STRING
        },
        idMatkul: Sequelize.STRING,
        hari: Sequelize.STRING,
        jam: Sequelize.TIME,
        idDosen: Sequelize.STRING,
        idTugas: {
            type: Sequelize.STRING,
            allowNull: true
        },
        status: Sequelize.STRING,
        isTemp: Sequelize.INTEGER,
    }, {
            timestamps: false,
            underscored: false,
            tableName: "kuliah"
        })

    KuliahTemp.findAll().then((datum) => {
        datum.forEach(data => {
            Kuliah.findOne({
                where: {
                    idKuliah: data.idKuliah
                }
            }).then((kuliahData) => {
                // console.log()
                kuliahData.update(data.dataValues).then(() => {
                    data.destroy({ force: true })
                })
            })
        })
    })
}

const cronConfig = {
    cronTime: '0 23 * * SUN',
    onTick: () => {
        reset();
    },
    start : true,
    timeZone: 'Asia/Makassar',
}

setInterval(() => {
    console.log("run");
},"3000");

const ch = new Cron.CronJob(cronConfig);