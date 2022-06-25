<?php

if ( !defined( "root" ) ) die;

class be {

	protected $action = null;
	protected $endpoint = null;
	protected $ps = null;
	protected $response_sta  = null;
	protected $response_data = null;
	protected $http_headers = array(
		"ok" => "HTTP/1.1 202 OK",
		"failed" => "HTTP/1.1 200 OK"
	);

	protected $endpoints = array(

		// Global Actions
		"spotify_create" => [
			"required_page"   => [ "search", "artist" ],
			"required_inputs" => [
				"qn" => [
					"type" => "string",
					"args" => [
						"empty()",
						"max_length" => 100,
					]
				],
				"type" => [
					"type" => "in_array",
					"args" => [
						"values" => [ "album", "artist", "track" ]
					]
				],
				"hook" => [
					"type" => "string",
					"args" => [
						"strict" => true
					]
				],
			]
		],
		"waveform_create" => [
			"required_page"   => [ "track" ],
			"required_inputs" => [
				"hash" => [
					"type" => "md5"
				],
				"track_hash" => [
					"type" => "md5"
				]
			]
		],
		"download_music" => [
			"required_page"   => [ "track", "album", "playlist" ],
			"required_inputs" => [
				"type" => [
					"type" => "in_array",
				    "args" => [
					    "values" => [
						    "file",
						    "link"
					    ]
				    ]
				],
				"ids" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9,]"
					]
				]
			],
 		],
		"special_buttons" => [
			"required_page"   => [ "track", "album", "playlist", "page", "user" ],
			"required_inputs" => [
				"type" => [
          "type" => "in_array",
					"args" => [
						"values" => [
							"track",
							"playlist"
						]
					],
				],
				"hash" => [
					"type" => "md5"
				]
			]
		],
		"get_ad_link" => [
			"required_inputs" => [
				"ad_id" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9_]"
					]
				]
			]
		],

		// Guest Actions
		"user_signup" => [
			"required_page"   => [ "user_signup" ],
			"required_inputs" => [
				"email" => [
					"type" => "email"
				],
				"username" => [
					"type" => "username"
				],
				"password" => [
					"type" => "password"
				],
				"password2" => [
					"type" => "password"
				],
				"terms_agreed" => [
					"type" => "checkbox"
				]
			]
		],
		"user_login" => [
			"required_page"   => [ "user_login" ],
			"required_inputs" => [
				"email" => [
					"type" => "email"
				],
				"password" => [
					"type" => "password"
				]
			],
		],
		"user_recover" => [
			"required_page"   => [ "user_recover" ],
			"required_inputs" => [
				"email" => [
					"type" => "email"
				]
			]
		],
		"user_recover2" => [
			"required_page"   => [ "user_recover" ],
			"required_inputs" => [
				"password" => [
					"type" => "password"
				],
				"password2" => [
					"type" => "password"
				],
			]
		],

		// Admin input suggestion maker
		"admin_get_suggestions" => [
			"required_inputs" => [
				"type" => [
					"type" => "in_array",
				    "args" => [
					    "values" => [
						    "user",
						    "track_id",
						    "album_id",
						    "genre_id",
						    "artist_id",
						    "album_title",
						    "artist_name"
					    ]
				    ]
				],
				"q" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"max_length" => 30
					]
				],
			],
		],

		// Admin UI editor actions
		"admin_save_theme_setting" => [
			"required_page" => [ "admin_theme_setting" ],
		],
		"admin_save_menu" => [
			"required_page"   => [ "admin_menu_editor" ],
			"required_inputs" => [
				"name" => [
					"type" => "username",
				],
				"data" => [
					"type" => "json"
				]
			]
		],
		"admin_remove_menu" => [
			"required_page"   => [ "admin_menu_editor" ],
			"required_inputs" => [
				"name" => [
					"type" => "username",
				]
			]
		],
		"admin_save_page" => [
			"required_page"   => [ "admin_page_editor" ],
			"required_inputs" => [
				"name" => [
					"type" => "username"
				],
				"url" => [
					"type" => "string",
					"args" => [
						"strict" => true
					]
				],
				"data" => [
					"type" => "json"
				]
			]
		],
		"admin_save_page_snoop_spotify" => [
			"required_page"   => [ "admin_page_editor" ],
			"required_inputs" => [
				"query" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[\p{L}0-9_.\- ]"
					]
				],
				"widID" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9._-]"
					]
				]
			]
		],
		"admin_remove_page" => [
			"required_page"   => [ "admin_page_editor" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int",
				],
			]
		],
		"admin_index_page" => [
			"required_page"   => [ "admin_page_editor" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int",
				],
			]
		],
		"admin_new_language" => [
			"required_page" => [ "admin_language_editor" ],
			"required_inputs" => [
				"code" => [
					"type" => "string_lang_code"
				],
				"name" => [
					"type" => "string",
					"args" => [
						"strict" => true
					]
				]
			]
		],
		"admin_remove_language" => [
			"required_page" => [ "admin_language_editor" ],
			"required_inputs" => [
				"code" => [
					"type" => "string_lang_code"
				],
			]
		],
		"admin_edit_language" => [
			"required_page"   => [ "admin_language_editor" ],
			"required_inputs" => [
				"hook" => [
					"type" => "username",
					"args" => [
						"min_length" => 2
					]
				],
				"text" => [
					"type" => "string",
					"args" => [
						"allow_eol" => true
					]
				]
			]
		],

		// Admin setting actions
		"admin_save_setting_general" => [
			"required_page"   => [ "admin_setting_general" ],
			"required_inputs" => [
				"sitename" => [
					"type" => "string"
				],
				"web_addr" => [
					"type" => "url"
				],
				"theme_name" => [
					"type" => "username"
				],
				"lang" => [
					"type" => "string_lang_code"
				],
				"up_timeout" => [
					"type" => "int",
					"args" => [
						"min" => 10,
						"max" => 200
					]
				],
				"default_gid" => [
					"type" => "int",
					"args" => [
						"min" => 1,
						"max" => 99
					]
				],
				"heard_ratio" => [
					"type" => "int",
					"args" => [
						"min" => 1,
						"max" => 100
					]
				],
				"twitter_username" => [
					"type" => "username",
					"args" => [
						"empty()"
					]
				],
				"signup_verified" => [
					"type" => "checkbox"
				],
				"redirect_single_album" => [
					"type" => "checkbox"
				],
				"prefer_localfile" => [
					"type" => "checkbox"
				],
				"video_display" => [
					"type" => "checkbox"
				],
				"station" => [
					"type" => "checkbox"
				],
			]
		],
		"admin_save_setting_api" => [
			"required_page"   => [ "admin_setting_api" ],
			"required_inputs" => [
				"spotify_id" => [
					"type" => "md5",
					"args" => [
						"empty()"
					]
				],
				"spotify_key" => [
					"type" => "md5",
					"args" => [
						"empty()"
					]
				],
				"spotify_w_u_i" => [
					"type" => "int",
					"args" => [
						"min" => 1,
						"max" => 720
					]
				],
				"req_proxy" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9_.-\:]"
					]
				],
				"req_proxy_a" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9_.-\:@]"
					]
				],
				"yt_key" => [
					"type" => "string",
					"args" => [
						"empty()",
						"allow_eol" => true
					]
				],
				"get_visitor_ip_data" => [
					"type" => "checkbox"
				],
				"spotify_search" => [
					"type" => "checkbox"
				],
				"spotify_upload" => [
					"type" => "checkbox"
				],
				"spotify_upload_e" => [
					"type" => "checkbox"
				],
				"spotify_d_a" => [
					"type" => "checkbox"
				],
				"spotify_d_ar" => [
					"type" => "checkbox"
				],
				"spotify_d_a_ts" => [
					"type" => "checkbox"
				],
				"spotify_d_la_ts" => [
					"type" => "checkbox"
				],
				"spotify_g_c" => [
					"type" => "checkbox"
				],
				"utube_api" => [
					"type" => "checkbox"
				],
				"youtube_d_t" => [
					"type" => "checkbox"
				],
			]
		],
		"admin_save_setting_upload" => [
			"required_page"   => [ "admin_setting_upload" ],
			"required_inputs" => [
				"chunk_size" => [
					"type" => "int",
					"args" => [
						"min" => 1,
						"max" => 20
					]
				],
				"max_par_ups" => [
					"type" => "int",
					"args" => [
						"min" => 1,
						"max" => 10
					]
				],
				"max_size" => [
					"type" => "int",
					"args" => [
						"min" => 2,
						"max" => 500
					]
				],
				"upload_min_bitrate" => [
					"type" => "int",
					"args" => [
						"min" => 20,
						"max" => 600
					]
				],
				"upload_min_cover" => [
					"type" => "int",
					"args" => [
						"min" => 100,
						"max" => 1000
					]
				],
				"chunk" => [
					"type" => "checkbox"
				],
				"upload_write_id3" => [
					"type" => "checkbox"
				]
			]
		],
		"admin_save_setting_upload_aws" => [
			"required_page"   => [ "admin_setting_upload_aws" ],
			"required_inputs" => [
				"aws_protect" => [
					"type" => "checkbox"
				],
				"aws" => [
					"type" => "checkbox"
				],
				"aws_key" => [
				  "type" => "string",
					"args" => [
					  "strict" => true,
						"strict_regex" => "[a-zA-Z0-9,.]",
						"empty()"
					]
				],
				"aws_secret" => [
				  "type" => "string",
					"args" => [
					  "strict" => true,
						"strict_regex" => "[a-zA-Z0-9,.]",
						"empty()"
					]
				],
				"aws_bucket" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_]",
						"empty()"
					]
				],
				"aws_region" => [
				  "type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_]",
						"empty()"
					]
				],
				"aws_endpoint" => [
				  "type" => "url",
					"args" => [
						"empty()"
					]
				],
				"ftp" => [
					"type" => "checkbox"
				],
				"ftp_address" => [
					"type" => "string",
					"args" => [
					  "strict" => true,
						"strict_regex" => "[a-zA-Z0-9.\-_]",
						"empty()"
					]
				],
				"ftp_path" => [
					"type" => "string",
					"args" => [
					  "strict" => true,
						"strict_regex" => "[\/a-zA-Z0-9_.\- ]",
						"empty()"
					]
				],
				"ftp_port" => [
					"type" => "int",
				],
				"ftp_ssl" => [
					"type" => "checkbox",
				],
				"ftp_username" => [
					"type" => "username",
					"args" => [ "empty()" ]
				],
				"ftp_password" => [
					"type" => "password",
					"args" => [ "empty()" ]
				],
				"ftp_web_address" => [
					"type" => "url",
					"args" => [ "empty()" ]
				],
			]
		],
		"admin_save_setting_pay" => [
			"required_page"   => [ "admin_setting_pay" ],
			"required_inputs" => [
				"currency_code" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"min_length" => 1,
						"max_length" => 20
					]
				],
				"currency_format" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9%.\-\$_ ]",
						"min_length" => 10,
						"max_length" => 25
					]
				],
				"currency" => [
					"type" => "string",
					"args" => [
						"min_length" => 1,
						"max_length" => 10
					]
				],
				"sell_music_prices" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,.]"
					]
				],
				"og_approved" => [
					"type" => "checkbox"
				],
				"upgrade_price" => [
					"type" => "float"
				],
				"withdrawal_min" => [
					"type" => "float"
				],
				"banner_v_cost" => [
					"type" => "float"
				],
				"adsense" => [
					"type" => "raw",
					"args" => [
						"empty()"
					]
				],
				"banner_c_cost" => [
					"type" => "float"
				],
				"audio_v_cost" => [
					"type" => "float"
				],
				"ad_audio_iv" => [
					"type" => "float"
				],
				"pg_op" => [
					"type" => "checkbox"
				],
				"bank_data" => [
					"type" => "string",
					"args" => [
						"allow_eol" => true
					]
				],
				"pg_cp" => [
					"type" => "checkbox"
				],
				"pg_cp_k1" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_cp_k2" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_cp_k3" => [
					"type" => "string",
					"args" => [
						"empty()",
					]
				],
				"pg_cp_k4" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_cp_cr" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_pp" => [
					"type" => "checkbox"
				],
				"pg_pp_sb" => [
					"type" => "in_array",
					"args" => [
						"values" => [
							"live", "sandbox"
						]
					]
				],
				"pg_pp_k1" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_pp_k2" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_st" => [
					"type" => "checkbox"
				],
				"pg_st_k1" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_st_k2" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_ps" => [
					"type" => "checkbox"
				],
				"pg_ps_k1" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_ps_k2" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_kk" => [
					"type" => "checkbox"
				],
				"pg_kk_sb" => [
					"type" => "in_array",
					"args" => [
						"values" => [
							"live", "sandbox"
						]
					]
				],
				"pg_kk_k1" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_kk_k2" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_kk_k3" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_fw" => [
					"type" => "checkbox"
				],
				"pg_fw_sb" => [
					"type" => "in_array",
					"args" => [
						"values" => [
							"live", "sandbox"
						]
					]
				],
				"pg_fw_k1" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_fw_k2" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_fw_k3" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],

				"pg_rp" => [
					"type" => "checkbox"
				],
				"pg_rp_sb" => [
					"type" => "in_array",
					"args" => [
						"values" => [
							"live", "sandbox"
						]
					]
				],
				"pg_rp_k1" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],
				"pg_rp_k2" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9\-_.]"
					]
				],

			]
		],
		"admin_save_setting_email" => [
			"required_page"   => [ "admin_setting_email" ],
			"required_inputs" => [
				"email_s_type" => [
					"type" => "in_array",
					"args" => [
						"values" => [
							"smtp",
							"mail"
						]
					]
				],
				"email_s_host" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[A-Za-z0-9-.\:\/\\@]"
					]
				],
				"email_s_port" => [
					"type" => "int",
					"args" => [
						"empty()",
					]
				],
				"email_s_user" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[A-Za-z0-9-.\:\/\\@]"
					]
				],
				"email_s_pass" => [
					"type" => "password",
					"args" => [
						"empty()",
					]
				],
				"email_s_encrypt" => [
					"type" => "in_array",
					"args" => [
						"values" => [
							"tls",
							"ssl"
						]
					]
				],
			]
		],
		"admin_save_setting_programs" => [
			"required_page"   => [ "admin_setting_programs" ],
			"required_inputs" => [
				"ffmpeg_path" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => '[a-zA-Z0-9._\:\"\-\/\\\\]',
						"empty()"
					]
				],
				"youtube_dl_path" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => '[a-zA-Z0-9._\:\"\-\/\\\\]',
						"empty()"
					]
				],
				"ffmpeg" => [
					"type" => "checkbox"
				],
				"ffmpeg_wave" => [
					"type" => "checkbox"
				],
				"ffmpeg_convert" => [
					"type" => "int",
					"args" => [
						"min" => 0
					]
				],
				"youtube_dl" => [
					"type" => "checkbox"
				],
			]
		],
		"admin_save_setting_download" => [
			"required_page"   => [ "admin_setting_download" ],
			"required_inputs" => [
				"download_lock" => [
					"type" => "checkbox"
				],
				"download_limit" => [
					"type" => "int",
					"args" => [
						"min" => 0,
						"max" => 50
					]
				],
				"download_range" => [
					"type" => "int",
					"args" => [
						"min" => 10,
						"max" => 2592000
					]
				],
			]
		],
		"admin_save_setting_sessions" => [
			"required_pages"  => [ "admin_setting_sessions" ],
			"required_inputs" => [
				"session_i_lock" => [
					"type" => "checkbox"
				],
				"session_p_lock" => [
					"type" => "checkbox"
				],
				"session_max" => [
					"type" => "int",
					"args" => [
						"min" => 0,
						"max" => 20
					]
				],
				"session_lifetime" => [
					"type" => "int",
					"args" => [
						"min" => 0,
						"max" => 43200
					]
				],
			],
		],
		"admin_save_setting_social_login" => [
			"required_page" => [ "admin_setting_social_login" ],
			"required_inputs" => [
				"sl_fb" => [
					"type" => "checkbox"
				],
				"sl_fb_k1" => [
					"type" => "string",
					"args" => [
						"empty()"
					]
				],
				"sl_fb_k2" => [
					"type" => "string",
					"args" => [
						"empty()"
					]
				],
				"sl_ggl" => [
					"type" => "checkbox"
				],
				"sl_ggl_k1" => [
					"type" => "string",
					"args" => [
						"empty()"
					]
				],
				"sl_ggl_k2" => [
					"type" => "string",
					"args" => [
						"empty()"
					]
				],
				"sl_tw" => [
					"type" => "checkbox"
				],
				"sl_tw_k1" => [
					"type" => "string",
					"args" => [
						"empty()"
					]
				],
				"sl_tw_k2" => [
					"type" => "string",
					"args" => [
						"empty()"
					]
				],
				"sl_ig" => [
					"type" => "checkbox"
				],
				"sl_ig_k1" => [
					"type" => "string",
					"args" => [
						"empty()"
					]
				],
				"sl_ig_k2" => [
					"type" => "string",
					"args" => [
						"empty()"
					]
				],
			]
		],
		"admin_save_setting_notifications" => [
			"required_page" => [ "admin_setting_notifications" ],
			"required_inputs" => [
				"admin_ids" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]",
						"min_length" => 1
					]
				],
				"ua_acts" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				],
				"ua_feeds" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				],
				"ua_nots" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				],
				"ua_emails" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				],
				"admin_ids" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				],
			]
		],
		"admin_test_ftp" => [
			"required_page" => [ "admin_setting_upload_aws" ]
		],
		"admin_test_aws" => [
			"required_page" => [ "admin_setting_upload_aws" ]
		],
		"admin_test_youtube_dl" => [
			"required_page" => [ "admin_setting_programs" ]
		],
		"admin_test_ffmpeg" => [
			"required_page" => [ "admin_setting_programs" ]
		],
		"admin_test_smtp" => [
			"required_page" => [ "admin_setting_email" ]
		],

		// Admin user-management actions
		"admin_users_edit_group" => [
			"required_page"   => [ "admin_user_groups" ],
			"required_inputs" => [
				"muse_access" => [
					"type" => "checkbox"
				],
				"hq_audio_access" => [
					"type" => "checkbox"
				],
				"premium_access" => [
					"type" => "checkbox"
				],
				"download_access" => [
					"type" => "checkbox"
				],
				"language_access" => [
					"type" => "checkbox"
				],
				"signup_access" => [
					"type" => "checkbox"
				],
				"upload_access" => [
					"type" => "checkbox"
				],
				"sell_access" => [
					"type" => "checkbox"
				],
				"report_access" => [
					"type" => "checkbox"
				],
				"comment_access" => [
					"type" => "checkbox"
				],
				"notification_access" => [
					"type" => "checkbox"
				],
				"hide_advertisement_access" => [
					"type" => "checkbox"
				],
				"advertisement_access" => [
					"type" => "checkbox"
				],
				"upgrade_access" => [
					"type" => "checkbox"
				],
				"artist_req_access" => [
					"type" => "checkbox"
				],
				"admin_access" => [
					"type" => "checkbox"
				],
				"verified" => [
					"type" => "checkbox"
				],
				"sell_share" => [
					"type" => "int",
					"args" => [
						"empty()",
						"min" => 0,
						"max" => 100
					]
				],
				"ui_access" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[*a-z,_-]"
					]
				],
				"be_access" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strict" => true,
						"strict_regex" => "[*a-z,_-]"
					]
				],
			]
		],
		"admin_users_remove_group" => [
			"required_page"   => [ "admin_user_groups" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int",
				]
			]
		],
		"admin_users_new_group" => [
			"required_page"   => [ "admin_user_groups" ],
			"required_inputs" => [
				"name" => [
					"type" => "username",
					"args" => [
						"min_length" => 2
					]
				]
			]
		],
		"admin_delete_users" => [
			"required_page"   => [ "admin_users" ],
			"required_inputs" => [
				"new_user" => [
					"type" => "int",
					"args" => [
						"min" => 0
					]
				],
				"users" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				],
			]
		],
		"admin_edit_user" => [
			"required_page"   => [ "admin_users" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				],
				"group" => [
					"type" => "int"
				],
				"username" => [
					"type" => "username"
				],
				"name" => [
					"type" => "string"
				],
				"email" => [
					"type" => "email"
				],
				"new_password" => [
					"type" => "password",
					"args" => [
						"empty()"
					]
				],
				"fund" => [
					"type" => "float",
					"args" => [
						"empty()",
						"max" => 1000000
					]
				],
				"time_paid_expire" => [
					"type" => "string_date",
					"args" => [
						"empty()"
					]
				],
			]
		],
		"admin_user_verify" => [
			"required_page"   => [ "admin_users" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				]
			]
		],
		"admin_user_connect" => [
			"required_page"   => [ "admin_users" ],
			"required_inputs" => [
				"artist_id" => [
					"type" => "int"
				],
				"user_id" => [
					"type" => "int"
				]
			]
		],
		"admin_user_disconnect" => [
			"required_page"   => [ "admin_users" ],
			"required_inputs" => [
				"artist_id" => [
					"type" => "int",
					"args" => [
						"empty()"
					]
				],
				"user_id" => [
					"type" => "int",
					"args" => [
						"empty()"
					]
				],
			]
		],
		"admin_delete_comments" => [
			"required_page"   => [ "admin_user_comments" ],
			"required_inputs" => [
				"comments" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				]
			]
		],
		"admin_approve_comments" => [
			"required_page"   => [ "admin_user_comments" ],
			"required_inputs" => [
				"comments" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				]
			]
		],
		"admin_approve_payments" => [
			"required_page"   => [ "admin_user_payments" ],
			"required_inputs" => [
				"payments" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				]
			]
		],
		"admin_reject_payments" => [
			"required_page"   => [ "admin_user_payments" ],
			"required_inputs" => [
				"payments" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				]
			]
		],
		"admin_artist_withdraw_remove" => [
			"required_page"   => [ "admin_user_withdraws" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				]
			]
		],
		"admin_artist_withdraw_done" => [
			"required_page"   => [ "admin_user_withdraws" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				]
			]
		],
		"admin_accept_artist" => [
			"required_page"   => [ "admin_user_artist_reqs" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				]
			]
		],
		"admin_reject_artist" => [
			"required_page"   => [ "admin_user_artist_reqs" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				]
			]
		],
		"admin_manage_ads" => [
			"required_page"   => [ "admin_user_ads" ],
			"required_inputs" => [
				"hook" => [
					"type" => "int"
				],
				"sta" => [
					"type" => "int",
					"args" => [
						"max" => 10,
						"min" => -10
					]
				]
			]
		],
		"admin_edit_ad" => [
			"required_page"   => [ "admin_user_ads" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				],
				"name" => [
					"type" => "string",
				],
				"url" => [
					"type" => "url"
				],
				"fund_total" => [
					"type" => "float"
				],
				"fund_remain" => [
					"type" => "float",
					"args" => [
						"min" => 0,
					]
				],
				"fund_limit" => [
					"type" => "float",
					"args" => [
						"min" => 0,
					]
				],
				"fund_spent" => [
					"type" => "float",
					"args" => [
						"min" => 0,
					]
				],
				"fund_spent_day" => [
					"type" => "float",
					"args" => [
						"min" => 0,
					]
				],
				"placements" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-z0-9A-Z,_]",
						"empty()"
					]
				],
				"active" => [
					"type" => "in_array",
					"args" => [
						"values" => [ -2, -1, 0, 1, 2, "-2", "-1", "0", "1", "2" ],
					]
				]
			]
		],
		"admin_edit_adsense" => [
			"required_page"   => [ "admin_user_ads" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int",
					"args" => [
						"empty()"
					]
				],
				"name" => [
					"type" => "string",
				],
				"code" => [
					"type" => "raw",
				],
				"placements" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-z0-9A-Z,_]",
						"empty()"
					]
				],
				"active" => [
					"type" => "in_array",
					"args" => [
						"values" => [ 1, 2, "1", "2" ],
					]
				]
			]
		],

		// Admin content-management actions
		"admin_new_genre" => [
			"required_page"   => [ "admin_content_genres" ],
			"required_inputs" => [
				"name" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[\p{L}0-9_.\-& ]"
					]
				]
			]
		],
		"admin_recover_genre" => [
			"required_page"   => [ "admin_content_genres" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				]
			]
		],
		"admin_delete_genre" => [
			"required_page"   => [ "admin_content_genres" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				]
			]
		],
		"admin_edit_genre" => [
			"required_page"   => [ "admin_content_genres" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				],
				"name" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[\p{L}0-9_.\-& ]"
					],
				]
			]
		],
		"admin_remove_genres" => [
			"required_page"   => [ "admin_content_genres" ],
			"required_inputs" => [
				"new_genre" => [
					"type" => "int"
				],
				"genres" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				]
			],
		],
		"admin_delete_artists" => [
			"required_page"   => [ "admin_content_artists" ],
			"required_inputs" => [
				"new_artist" => [
					"type" => "int",
					"args" => [
						"min" => 0
					]
				],
				"artists" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				]
			]
		],
		"admin_edit_artist" => [
			"required_page"   => [ "admin_content_artists" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				],
				"name" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true,
					]
				],
				"spotify_id" => [
					"type" => "string_spotify_id",
					"args" => [
						"empty()"
					]
				],
			]
		],
		"admin_delete_albums" => [
			"required_page"   => [ "admin_content_albums" ],
			"required_inputs" => [
				"albums" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				],
				"new_album" => [
					"type" => "int",
					"args" => [
						"min" => 0
					]
				]
			]
		],
		"admin_edit_album" => [
			"required_page"   => [ "admin_content_albums" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				],
				"price" => [
					"type" => "float",
					"args" => [
						"empty()"
					]
				],
				"title" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],
				"type" => [
					"type" => "username",
				],
				"time_release" => [
					"type" => "string_date"
				],
				"comment" => [
					"type" => "string",
					"args" => [
						"empty()",
						"allow_eol" => true
					]
				],
				"user_id" => [
					"type" => "int",
					"args" => [
						"min" => 0,
						"empty()"
					]
				],
				"genre" => [
					"type" => "string"
				],
				"spotify_id" => [
					"type" => "string_spotify_id",
					"args" => [
						"empty()"
					]
				],
				"artist_name" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],

			]
		],
		"admin_new_track" => [
			"required_page"   => [ "admin_content_tracks" ],
			"required_inputs" => [
				"title" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],
				"artist_name" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],
				"album_title" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true,
						"empty()"
					]
				],
				"album_artist_name" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true,
						"empty()"
					]
				],
				"album_order" => [
					"type" => "int",
					"args" => [
						"min" => 0,
						"empty()"
					]
				],
				"genre" => [
					"type" => "string",
					"args" => [
						"strict" => true
					]
				],
				"spotify_id" => [
					"type" => "string_spotify_id",
					"args" => [
						"empty()"
					]
				],
				"artists_featured" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strip_emoji" => true
					]
				],
				"user_id" => [
					"type" => "int",
					"args" => [
						"min" => 0,
						"empty()"
					]
				],
				"price" => [
					"type" => "float",
					"args" => [
						"empty()"
					]
				],
				"text_comment" => [
					"type" => "string",
					"args" => [
						"empty()"
					]
				],
				"text_lyrics" => [
					"type" => "string",
					"args" => [
						"empty()"
					]
				],
				"album_type" => [
					"type" => "username"
				],
				"album_genre" => [
					"type" => "string",
					"args" => [
						"strict" => true
					]
				],
				"time_release" => [
					"type" => "string_date"
				],
				"duration" => [
					"type" => "int",
					"args" => [
						"empty()"
					]
				],
			]
		],
		"admin_edit_track" => [
			"required_page"   => [ "admin_content_tracks" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				],
				"title" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],
				"artist_name" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],
				"album_title" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true,
						"empty()"
					]
				],
				"album_artist_name" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true,
						"empty()"
					]
				],
				"album_order" => [
					"type" => "int",
					"args" => [
						"min" => 0,
						"empty()"
					]
				],
				"genre" => [
					"type" => "string",
					"args" => [
						"strict" => true
					]
				],
				"spotify_id" => [
					"type" => "string_spotify_id",
					"args" => [
						"empty()"
					]
				],
				"artists_featured" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true,
						"empty()"
					]
				],
				"user_id" => [
					"type" => "int",
					"args" => [
						"min" => 0,
						"empty()"
					]
				],
				"price" => [
					"type" => "float",
					"args" => [
						"min" => 0,
						"empty()"
					]
				],
				"time_release" => [
					"type" => "string_date"
				],
				"text_comment" => [
					"type" => "string",
					"args" => [
						"empty()",
						"allow_eol" => true
					]
				],
				"text_lyrics" => [
					"type" => "string",
					"args" => [
						"empty()",
						"allow_eol" => true
					]
				],
				"duration" => [
					"type" => "int",
					"args" => [
						"empty()"
					]
				]
			]
		],
		"admin_delete_tracks" => [
			"required_page"   => [ "admin_content_tracks", "admin_user_reports" ],
			"required_inputs" => [
				"tracks" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				]
			]
		],
		"admin_dismiss_reports" => [
		  "required_page" => [ "admin_user_reports" ],
			"required_inputs" => [
				"tracks" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				]
			]
		],
		"admin_delete_sources" => [
			"required_page"   => [ "admin_content_sources" ],
			"required_inputs" => [
				"sources" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				]
			]
		],
		"admin_delete_source_waves" => [
			"required_page"   => [ "admin_content_sources" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int",
				]
			]
		],
		"admin_new_source" => [
			"required_page"   => [ "admin_content_sources" ],
			"required_inputs" => [
				"track_id" => [
					"type" => "int",
				],
				"type" => [
					"type" => "in_array",
					"args" => [
						"values" => [ "local", "youtube" ]
					]
				],
				"youtube" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"empty()"
					]
				],
				"duration" => [
					"type" => "int"
				]
			]
		],

		// Admin tools
		"admin_tool_update_widget" => [
			"required_page"   => [ "admin_tools_bot_runner" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				]
			]
		],
		"admin_tools_translate" => [
			"required_page"   => [ "admin_tools_auto_translate" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				],
				"code" => [
					"type" => "string_lang_code"
				]
			]
		],
		"admin_tool_cleaner_job" => [
			"required_page"   => [ "admin_tools_cleaner" ],
			"required_inputs" => [
				"type" => [
					"type" => "in_array",
					"args" => [
						"values" => [ "folder", "query" ]
					]
				],
				"job" => [
					"type" => "raw"
				]
			]
		],

		// Uploading and editing music
		"user_upload_music" => [
			"required_page" => [ "user_upload" ]
		],
		"user_update_uploading_cover" => [
			"required_page"   => [ "user_upload_edit" ],
			"required_inputs" => [
				"album_code" => [
					"type" => "string_code"
				]
			]
		],
		"user_update_uploading_track" => [
			"required_page"   => [ "user_upload_edit" ],
			"required_inputs" => [
				"rID" => [
					"type" => "md5"
				],
				"title" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],
				"artist_name" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],
				"album_type" => [
					"type" => "in_array",
					"args" => [
						"values" => [ 'single', 'mixtape', 'compilation', 'studio', 'live' ]
					]
				],
				"album_title" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strip_emoji" => true
					]
				],
				"album_artist_name" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strip_emoji" => true
					]
				],
				"album_order" => [
					"type" => "int",
					"args" => [
						"min" => 0,
						"empty()"
					]
				],
				"genre" => [
					"type" => "string",
					"args" => [
						"strict" => true,
					]
				],
				"spotifyID" => [
					"type" => "string_spotify_id",
					"args" => [
						"empty()"
					]
				],
				"artists_featured" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strip_emoji" => true
					]
				],
				"comment" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strip_emoji" => true,
						"allow_eol" => true
					]
				],
				"lyrics" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strip_emoji" => true,
						"allow_eol" => true
					]
				],
				"price" => [
					"type" => "float",
					"args" => [
						"empty()",
						"min" => 0
					]
				]
			]

		],
		"user_update_uploading_album" => [
			"required_page"   => [ "user_upload_edit" ],
			"required_inputs" => [
				"code" => [
					"type" => "string_code"
				],
				"type" => [
					"type" => "in_array",
					"args" => [
						"values" => [ 'single', 'mixtape', 'compilation', 'studio', 'live' ]
					]
				],
				"title" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],
				"artist_name" => [
					"type" => "string",
					"args" => [
						"empty()",
						"strip_emoji" => true
					]
				],
				"genre" => [
					"type" => "string",
					"args" => [
						"strict" => true
					]
				],
				"spotifyID" => [
					"type" => "string_spotify_id",
					"args" => [
						"empty()"
					]
				],
				"comment" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true,
						"empty()",
						"allow_eol" => true
					]
				],
				"time" => [
					"type" => "string_date"
				],
				"price" => [
					"type" => "float",
					"args" => [
						"empty()",
						"min" => 0
					]
				]
			]

		],
		"user_update_finalize_edit" => [
			"required_page" => [ "user_upload_edit" ]
		],

		// Report
		"user_act_report_track" => [
			"required_page" => [ "track" ],
			"required_inputs"	=> [
				"hash" => [
					"type" => "md5"
				],
				"reason" => [
					"type" => "string",
				]
			]
		],

		// User actions
		"user_get_nots" => [
			"required_inputs" => [
				"hash" => [
					"type" => "md5"
				],
				"full" => [
					"type" => "boolean"
				],
				"page" => [
					"type" => "int",
					"args" => [
						"max" => 50
					]
				]
			]
		],
		"user_act_like" => [
			"required_inputs" => [
				"hash" => [
					"type" => "md5"
				]
			]
		],
		"user_act_repost" => [
			"required_inputs" => [
				"hash" => [
					"type" => "md5"
				]
			]
		],
		"user_act_load_playlists" => [],
		"user_act_create_playlist" => [
			"required_inputs" => [
				"name" => [
					"type" => "string",
					"args" => [
						"max_length" => 50
					]
				]
			]
		],
		"user_act_extend_playlist" => [
			"required_inputs" => [
				"playlist_hash" => [
					"type" => "md5"
				],
				"track_hash" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9,]"
					]
				]
			]
		],
		"user_act_edit_playlist" => [
			"required_page" => [ "playlist" ],
			"required_inputs" => [
				"hook" => [
					"type" => "md5"
				],
				"name" => [
					"type" => "string",
					"args" => [
						"max_length" => 50
					]
				],
				"collabs" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9_.,]",
						"empty()"
					]
				]
			]
		],
		"user_act_sort_playlist" => [
			"required_page" => [ "playlist" ],
			"required_inputs" => [
				"playlist_hash" => [
					"type" => "md5"
				],
				"hashes" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9,]",
						"max_length"   => 4000
					]
				]
			]
		],
		"user_act_follow" => [
			"required_inputs" => [
				"target" => [
					"type" => "username"
				]
			]
		],
		"user_act_like_album" => [
			"required_page"   => [ "album" ],
			"required_inputs"	=> [
				"hook" => [
					"type" => "md5"
				]
			]
		],
		"user_act_like_playlist" => [
			"required_page"   => [ "playlist" ],
			"required_inputs"	=> [
				"hook" => [
					"type" => "md5"
				]
			]
		],
		"user_act_sub_playlist" => [
			"required_page"   => [ "playlist" ],
			"required_inputs"	=> [
				"hook" => [
					"type" => "md5"
				]
			]
		],
		"user_act_delete_comment" => [
			"required_page"   => [ "track" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				]
			]
		],
		"user_act_like_comment" => [
			"required_page"   => [ "track" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				]
			]
		],
		"user_act_lessen_playlist" => [
			"required_page"   => [ "playlist" ],
			"required_inputs" => [
				"playlist_hash" => [
					"type" => "md5"
				],
				"track_hash" => [
					"type" => "md5"
				]
			]
		],
		"user_act_remove_playlist" => [
			"required_page"   => [ "user_playlists", "playlist" ],
			"required_inputs" => [
				"hash" => [
					"type" => "md5"
				]
			]
		],
		"user_act_post_comment" => [
			"required_page"   => [ "track", "album" ],
			"required_inputs" => [
				"comment" => [
					"type" => "string",
					"args" => [
						"max_length" => 300
					]
				],
				"hash" => [
					"type" => "md5"
				],
				"m_hash" => [
					"type" => "md5",
					"args" => [
						"empty()"
					]
				],
				"m_seeker" => [
					"type" => "int",
					"args" => [
						"empty()"
					]
				],
				"PID" => [
					"type" => "int",
					"args" => [
						"empty()"
					]
				],
			]
		],
		"user_act_sub_artist" => [
			"required_inputs" => [
				"code" => [
					"type" => "string_code"
				]
			]
		],

		// User setting
		"user_setting_general_setting" => [
			"required_page"   => [ "user_setting" ],
			"required_inputs" => [
				"username" => [
					"type" => "username"
				],
			]
		],
		"user_setting_change_password" => [
			"required_page"   => [ "user_setting" ],
			"required_inputs" => [
				"password" => [
					"type" => "password"
				],
				"npassword" => [
					"type" => "password"
				],
				"npassword2" => [
					"type" => "password"
				]
			]
		],
		"user_setting_profile_setting" => [
			"required_page"   => [ "user_setting" ],
			"required_inputs" => [
				"name" => [
					"type" => "string",
					"args" => [
						"max_length" => 30,
						"strip_emoji" => true
					]
				],
				"website" => [
					"type" => "url",
					"args" => [
						"empty()"
					]
				],
				"facebook" => [
					"type" => "username",
					"args" => [
						"empty()"
					]
				],
				"soundcloud" => [
					"type" => "username",
					"args" => [
						"empty()"
					]
				],
				"instagram" => [
					"type" => "username",
					"args" => [
						"empty()"
					]
				],
			]
		],
		"user_setting_end_session" => [
			"required_page"   => [ "user_setting" ],
			"required_inputs" => [
				"ID" => [
					"type" => "int"
				]
			]
		],
		"user_setting_feed_setting" => [
			"required_page"   => [ "user_setting" ],
			"required_inputs" => [
				"feed" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				],
				"not" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]"
					]
				],
				"email" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9,]",
						"empty()"
					]
				],
			]
		],
		"user_setting_artist_verification" => [
			"required_page"   => [ "user_setting" ],
			"required_inputs" => [
				"real_name" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],
				"stage_name" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],
				"data"=> [
					"type" => "string",
					"args" => [
						"strip_emoji" => true,
						"allow_eol" => true
					]
				]
			]
		],
		"user_setting_artist_withdrawal" => [
			"required_page"   => [ "user_setting" ],
			"required_inputs" => [
				"amount" => [
					"type" => "float"
				],
				"email" => [
					"type" => "email"
				],
				"data" => [
					"type" => "string",
					"args" => [
						"allow_eol" => true,
						"strict" => true,
						"empty()"
					]
				]
			]
		],
		"user_ads_create" => [
			"required_page" => [ "user_setting" ],
			"required_inputs" => [
				"name" => [
					"type" => "string",
					"args" => [
						"strip_emoji" => true
					]
				],
				"fund" => [
					"type" => "int",
					"args" => [
						"max" => 100000,
						"min" => 10
					]
				],
				"limit" => [
					"type" => "int",
					"args" => [
						"empty()",
						"max" => 10000,
						"min" => 5
					]
				],
				"url" => [
					"type" => "url"
				],
				"ad_type" => [
					"type" => "in_array",
					"args" => [
						"values" => [
							"banner_v",
							"banner_c",
							"audio_v"
						]
					]
				],
				"placements" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[a-zA-Z0-9_\-\., ]",
						"empty()"
					]
				],
			]
		],

		// User money-related actions
		"user_proceed_payment" => [
			"required_inputs" => [
				"amount" => [
					"type" => "int",
					"args" => [
						"min" => 1,
						"max" => 10000
					]
				],
				"name" => [
					"type" => "in_array",
					"args" => [
						"values" => [ "stripe", "paypal", "kkiapay", "paystack", "flutterwave", "coinpayments", "razorpay" ]
					]
				]
			]
		],
		"user_stripe" => [
			"required_inputs" => [
				"amount" => [
					"type" => "int"
				]
			],
		],
		"user_bank_transfer" => [
			"required_inputs" => [
				"amount" => [
					"type" => "float",
					"args" => [
						"min" => 1
					]
				]
			]
		],
		"user_bank_transfer_submit" => [
			"required_inputs" => [
				"amount" => [
					"type" => "float",
					"args" => [
						"min" => 1
					]
				]
			]
		],
		"user_purchase" => [
			"required_page"   => [ "track", "album", "user_upgrade" ],
			"required_inputs" => [
				"type" => [
					"type" => "in_array",
					"args" => [
						"values" => [ "track", "album", "pro" ]
					]
				],
				"hook" => [
					"type" => "md5",
					"args" => [
						"empty()"
					]
				]
			]
		],

		// Player
		"muse_add" => [
			"required_inputs" => [
				"que_to_top" => [
					"type" => "boolean"
				],
				"start_radio" => [
					"type" => "boolean"
				],
				"type" => [
					"type" => "in_array",
					"args" => [
						"values" => [ "artist", "album", "track", "playlist", "widget" ]
					]
				],
				"hash" => [
					"type" => "string",
					"args" => [
						"strict" => true,
						"strict_regex" => "[0-9a-zA-Z]"
					]
				]
			]
		],
		"muse_next_track" => [],
		"muse_prev_track" => [],
		"muse_get_track" => [
			"required_inputs" => [
				"second" => [
					"type" => "float",
					"args" => [
						"min" => 0
					]
				],
				"autoplay" => [
					"type" => "boolean",
					"args" => [
						"empty()"
					]
				],
				"pl" => [
					"type" => "boolean",
					"args" => [
						"empty()"
					]
				]
			],
		],
		"muse_get_que" => [],
		"muse_set_volume" => [
			"required_inputs" => [
				"volume" => [
					"type" => "int",
					"args" => [
						"min" => 0
					]
				]
			]
		],
		"muse_set_repeat" => [
			"required_inputs" => [
				"value" => [
					"type" => "boolean"
				]
			]
		],
		"muse_clear_que" => [],
		"muse_shuffle_que" => [],
		"muse_remove_from_que" => [
			"required_inputs" => [
				"hash" => [
					"type" => "md5"
				]
			]
		],

	);

	public function __construct( $loader ){

		$this->loader = $loader;
		$this->db = $loader->db;

	}
	public function execute(){

		$requested_endpoint_name = null;

		if ( !empty( $_FILES['$file'] ) && ( $reqed_get = $this->loader->secure->get( "get", "action", "string" ) ) ){
			$requested_endpoint_name = $reqed_get;
		}
		elseif ( $reqed_post = $this->loader->secure->get( "post", "action", "string" ) ){
			$requested_endpoint_name = $reqed_post;
		}

		// Does requested action exists?
		if ( !$requested_endpoint_name ? true : !in_array( $requested_endpoint_name, array_keys( $this->endpoints ), true ) )
			$this->set_error( 'invalid_request_1', 1 );

		$this->action = $requested_endpoint_name;
		$this->endpoint = $this->endpoints[ $this->action ];

		// Can this action get executed from this page? ( compare BE to UI )
		if ( !empty( $this->endpoint[ "required_page" ] ) ? !in_array( $this->loader->ui->page_type, $this->endpoint[ "required_page" ], true ) : false )
			$this->set_error( 'invalid_request_2', 1 );

		// Can this user access this action?
		if ( !$this->loader->visitor->user()->has_access( "be", $this->action ) )
			$this->set_error( 'invalid_request_3' );

		// Are the user inputs valid?
		if ( !empty( $this->endpoint[ "required_inputs" ] ) ){
			// Go thro every required input
			foreach( $this->endpoint[ "required_inputs" ] as $_required_input_name => $_required_input_data ){
				// Check the input
				$this->check_user_input( $_required_input_name, $_required_input_data );
			}
		}

		// file exists?
		if ( !is_file( realpath( app_core_root . "/backend/{$this->action}.php" ) ) )
			$this->set_error( "Method:{$this->action} file is missing! This should not happen! contact admin ASAP!" );

		// Method is valid
		// UI and BE are in right sync
		// User has access to this method
		// User has sent all required inputs
		// User has sent valid inputs
		// All sent inputs are sanitized
		// Method file exists
		// Now require the requested method, double check everything && EXECUTE!
		$loader = $this->loader;
		require_once( realpath( app_core_root . "/backend/{$this->action}.php" ) );

	}

	protected function set_response( $data, $failed = false, $potential_hacker = false, $html_data = false ){

		$this->response_sta = !$failed;

		if ( is_array( $data ) )
			$this->response_data = json_encode( $data );

		elseif ( $html_data )
			$this->response_data = $data;

		// lorem->turn will try to find human-readable version of message/error if possible
		// it will also escape the text before returning it
		else
			$this->response_data = $this->loader->lorem->turn( $data, [ "uc" => true ] );

		// TODO:: record potential hacker data to notify admin and use it in Firewall

		$this->execute_response();

	}
	protected function set_error( $error, $potential_hacker = false, $html_data = false ){

		$this->set_response( $error, true, $potential_hacker, $html_data );

	}
	protected function set_error_header( $string ){

		$this->http_headers["failed"] = $string;
		return $this;

	}
	protected function execute_response(){

		header ( $this->response_sta ? $this->http_headers["ok"] : $this->http_headers["failed"] );
		echo $this->response_data;
		die();
		exit();

	}
	protected function check_user_input( $_required_input_name, $_required_input_data ){

		$__presented_value = isset( $_POST[ $_required_input_name ] ) ? $_POST[ $_required_input_name ] : null;

		// Check if user sent valid data
		// Besides validating, secure class also sanitize the input
		$validate = $this->loader->secure->validate(
			$__presented_value,
			$_required_input_data["type"],
			!empty( $_required_input_data["args"] ) ? $_required_input_data["args"] : []
		);

		// presented data is invalid
		// halt the process
		if ( !$validate ){
			$this->set_error( "invalid_{$_required_input_name}" );
			return false;
		}

		// Presented data is valid && sanitized
		$this->ps[ $_required_input_name ] = $__presented_value;
		return true;

	}

}

?>
