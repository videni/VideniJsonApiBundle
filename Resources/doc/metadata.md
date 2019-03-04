```yaml
App\Entity\Article:
    type: 'article'
    id: 'id'
    attributes:
        title:
            alias: 'title'
            groups: ['Article']
            type: string
        createdAt:
            alias: 'title'
            groups: ['Article']
            type: datetime
        subject: # An imaginary object, although it is a relation, we return it as an object
            alias: 'subject'
            groups: ['Article']
            type: object
    fieldsets:
         -  attribute_name: subject
            groups: ['Article']
            fields: ['id', 'title']
    relationships:
        author:
            alias: 'author'
            groups: ['Author']
            type: App\Entity\Author
            links:
                -   rel: self
                    href:  # Link to manipulate this relation.
                        route_name: 'api_relationship_article_author_view'
                        parameters:
                            articleId: object.getId()
                -   relf: related # Link to show this relation, also show this related resource object at the included section.
                    href:
                        route_name: 'api_subresource_article_author_view'
                        parameters:
                            articleId: object.getId()
        comments:
            groups: ['Comment']
            type: App\Entity\Comment
            links:
                -   rel: self
                    href:
                        route_name: 'api_relationship_article_comments_index'
                        parameters:
                            articleId: object.getId()
                -   rel: related
                    href:
                        route_name: 'api_subresource_article_comments_index'
                        parameters:
                            articleId: object.getId()
    included:
        author:
            type: App\Entity\Author
            groups: ['Author']
        comemnts:
            type: App\Entity\Comment
            groups: ['Comment']
    links:
        -   rel: self
            groups: ['Article']
            href:
                route_name: 'api_article_view'
                parameters:
                    id: object.getId()
App\Entity\Author:
    type: 'people'
    id: 'id'
    attributes:
        firstName:
            alias: 'first-name'
            groups: ['Author']
        lastName:
            alias: 'last-name'
            groups: ['Author']
    links:
        -   rel: self
            href:
                route_name: 'api_author_view'
                parameters:
                    id: object.getId()

App\Entity\Comment:
    type: 'comments'
    id: 'id'
    attributes:
        body: ~
    links:
        self:
            groups: ['Comment']
            href:
                route_name: 'api_comment_view'
                parameters:
                    id: object.getId()
```

```json
{
  "data": [{
    "type": "articles",
    "id": "1",
    "attributes": {
      "title": "JSON:API paints my bikeshed!"
    },
    "links": {
      "self": "http://example.com/articles/1"
    },
    "relationships": {
      "author": {
        "links": {
          "self": "http://example.com/articles/1/relationships/author",
          "related": "http://example.com/articles/1/author"
        },
        "data": { "type": "people", "id": "9" }
      },
      "comments": {
        "links": {
          "self": "http://example.com/articles/1/relationships/comments",
          "related": "http://example.com/articles/1/comments"
        },
        "data": [
          { "type": "comments", "id": "5" },
          { "type": "comments", "id": "12" }
        ]
      }
    }
  }],
  "included": [{
    "type": "people",
    "id": "9",
    "attributes": {
      "first-name": "Dan",
      "last-name": "Gebhardt",
      "twitter": "dgeb"
    },
    "links": {
      "self": "http://example.com/people/9"
    }
  }, {
    "type": "comments",
    "id": "5",
    "attributes": {
      "body": "First!"
    },
    "relationships": {
      "author": {
        "data": { "type": "people", "id": "2" }
      }
    },
    "links": {
      "self": "http://example.com/comments/5"
    }
  }, {
    "type": "comments",
    "id": "12",
    "attributes": {
      "body": "I like XML better"
    },
    "relationships": {
      "author": {
        "data": { "type": "people", "id": "9" }
      }
    },
    "links": {
      "self": "http://example.com/comments/12"
    }
  }]
}
```
