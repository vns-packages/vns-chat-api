# Chatting api package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vns/chatting-api.svg?style=flat-square)](https://packagist.org/packages/vns/chatting-api)
[![Total Downloads](https://img.shields.io/packagist/dt/vns/chatting-api.svg?style=flat-square)](https://packagist.org/packages/vns/chatting-api)
![GitHub Actions](https://github.com/vns/chatting-api/actions/workflows/main.yml/badge.svg)

small package to do task of any chatting task like manage conversations, messages, participants, ...

## Installation

You can install the package via composer:

```bash
composer require vns/chatting-api
```

## Usage

First You Must Publish migrations

```bash
php artisan vendor:publish --provider="VnsChattingApi\ChattingApiServiceProvider" --tag="migrations"
```

Publish config file

```bash
php artisan vendor:publish --provider="VnsChattingApi\ChattingApiServiceProvider" --tag="config"
```

Add Messageable Trait for participant model

```bash
use VnsChattingApi\Traits\Messageable;
```

## Manage Conversation

```php

// Create new Conversation
ChattingApiFacade::createConversation([$model1,$model2]); // create un-direct conversation
ChattingApiFacade::createDirectConversation([$model1,$model2]); // create direct conversation


// Get conversation by id
ChattingApiFacade::conversations()->getById($conversation_id);


// Get conversation messages
ChattingApiFacade::conversation($conversation)->setParticipant($participant)
            ->setPaginationParams([
                'page' => 1,
                'perPage' => 25,
                'sorting' => "desc",
                'columns' => [
                    '*'
                ],
                'pageName' => 'page'
            ])
            ->page($page)
            ->getMessages();

// OR

$participant->conversations;

// Get Count of unread messages for conversations for specific participant
ChattingApiFacade::conversation($conversation)->setParticipant($participant)->unreadCount();


// Get Conversation between two participant
ChattingApiFacade::conversations()->between( $participantOne,  $participantTwo);


// Clear all message notifications for one participant
ChattingApiFacade::conversations()->setParticipant($participant)->clear();


// Make all Messages as read by specific participant
ChattingApiFacade::conversations()->setParticipant($participant)->readAll();


// Add new participants for conversation
ChattingApiFacade::conversation($conversation)->addParticipants($participants);


// Remove participants from conversation
ChattingApiFacade::conversation($conversation)->removeParticipants($participants);
```

### conversations api

## Manage Participant

```php
// added Messageable Trait for participant model
use VnsChattingApi\Traits\Messageable;


// Get all conversations for participant
$participant->conversations();


// Join Conversation
$participant->joinConversation($conversation);


// leave Conversation
$participant->leaveConversation($conversation);
```

## Manage Message

```php

// Create new Message
ChattingApiFacade::message('message content')
        ->from($participant)
        ->to($conversation)
        ->send();

// Or

ChattingApiFacade::message('message content')
    ->from($participant)
    ->to($conversation)
    ->type('text')
    ->send();


// Delete Message For Specific Participant
ChattingApiFacade::messages()->getById($message_id)->trash($participant);
```
