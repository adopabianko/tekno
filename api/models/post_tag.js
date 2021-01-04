'use strict';
const {Model} = require('sequelize');
module.exports = (sequelize, DataTypes) => {
    class PostTag extends Model {
        static associate(models) {
            // define association here
        }
    };
    PostTag.init({
        postId: {type:DataTypes.INTEGER, field: 'post_id'},
        tagId: {type:DataTypes.INTEGER, field: 'tag_id'},
        createdAt: { type:DataTypes.DATE, field: 'created_at'},
        updatedAt: { type:DataTypes.DATE, field: 'updated_at'},
    }, {
        sequelize,
        modelName: 'PostTag',
        tableName: 'post_tags',
    });

    return PostTag
}
