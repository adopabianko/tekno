'use strict';
const {Model} = require('sequelize');

module.exports = (sequelize, DataTypes) => {
    class Post extends Model {
        static associate(models) {
            // define association here
            Post.belongsTo(models.Category, {
                as: 'category',
                foreignKey: 'category_id',
            });

            Post.belongsToMany(models.Tag, {
                as: 'tags',
                through: models.PostTag,
                foreignKey: 'post_id',
            });
        }
    };

    Post.init({
        category_id: DataTypes.INTEGER,
        title: DataTypes.STRING,
        slug: DataTypes.STRING,
        content: DataTypes.STRING,
        cover: DataTypes.STRING,
        createdAt: { type:DataTypes.DATE, field: 'created_at'},
        updatedAt: { type:DataTypes.DATE, field: 'updated_at'},
    }, {
        sequelize,
        modelName: 'Post',
        tableName: 'posts',
    });
    

    return Post;
}