'use strict'
const {Model} = require('sequelize');
module.exports = (sequelize, DataTypes) => {
    class Tag extends Model {
        static associate(models) {
            // define association here
            Tag.belongsToMany(models.Post, {
                as: 'tags',
                through: models.PostTag,
                foreignKey: 'tag_id',
            });
        } 
    };
    Tag.init({
        name: DataTypes.STRING,
        status: DataTypes.INTEGER,
        createdAt: { type:DataTypes.DATE, field: 'created_at' },
        updatedAt: { type:DataTypes.DATE, field: 'updated_at' },
    },{
        sequelize,
        modelName: 'Tag',
        tableName: 'tags',
    });

    return Tag;
}
