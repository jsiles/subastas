USE master
IF EXISTS(select * from sys.databases where name='subasta')
BEGIN
DROP DATABASE [subasta]
CREATE DATABASE [subasta]
END
ELSE
BEGIN
CREATE DATABASE [subasta]
END
GO
USE [subasta]
GO
/****** Object:  User [userSubasta]    Script Date: 03/02/2017 02:31:55 p.m. ******/
If not Exists (SELECT loginname FROM master.dbo.syslogins 
    WHERE name = 'userSubasta')
BEGIN
	CREATE LOGIN [userSubasta] WITH PASSWORD = 'Abc-1234';  
	CREATE USER [userSubasta] FOR LOGIN [userSubasta] WITH DEFAULT_SCHEMA=[dbo];
	ALTER ROLE [db_owner] ADD MEMBER [userSubasta]
	ALTER LOGIN [userSubasta] WITH CHECK_POLICY = OFF; 
END
ELSE
BEGIN
	ALTER LOGIN [userSubasta] WITH PASSWORD = 'Abc-1234';
	CREATE USER [userSubasta] FOR LOGIN [userSubasta] WITH DEFAULT_SCHEMA=[dbo];
	ALTER ROLE [db_owner] ADD MEMBER [userSubasta]
	ALTER LOGIN [userSubasta] WITH CHECK_POLICY = OFF;   

END
/****** Object:  Table [dbo].[mdl_banners]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_banners](
	[ban_uid] [int] IDENTITY(1,1) NOT NULL,
	[ban_title] [varchar](255) NULL DEFAULT (NULL),
	[ban_url] [varchar](255) NULL DEFAULT (NULL),
	[ban_content] [varchar](100) NULL,
	[ban_file] [varchar](255) NOT NULL,
 CONSTRAINT [PK_mdl_banners_ban_uid] PRIMARY KEY CLUSTERED 
(
	[ban_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_banners_contents]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_banners_contents](
	[mbc_uid] [int] NOT NULL,
	[mbc_con_uid] [int] NOT NULL,
	[mbc_ban_uid] [int] NOT NULL,
	[mbc_place] [int] NOT NULL,
	[mbc_position] [int] NOT NULL,
	[mbc_delete] [int] NOT NULL,
	[mbc_status] [varchar](8) NOT NULL,
 CONSTRAINT [PK_mdl_banners_contents_mbc_uid] PRIMARY KEY CLUSTERED 
(
	[mbc_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_bid]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_bid](
	[bid_uid] [int] NOT NULL,
	[bid_sub_uid] [int] NOT NULL,
	[bid_pro_uid] [int] NOT NULL,
	[bid_cli_uid] [int] NULL CONSTRAINT [DF__mdl_bid__bid_cli__1367E606]  DEFAULT (NULL),
	[bid_mount] [numeric](32, 2) NULL CONSTRAINT [DF__mdl_bid__bid_mou__145C0A3F]  DEFAULT (NULL),
	[bid_mountxfac] [numeric](32, 2) NOT NULL,
	[bid_date] [datetime2](0) NULL CONSTRAINT [DF__mdl_bid__bid_dat__15502E78]  DEFAULT (NULL),
	[bid_pca_uid] [int] NOT NULL,
 CONSTRAINT [PK_mdl_bid_bid_uid] PRIMARY KEY CLUSTERED 
(
	[bid_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_biditem]    Script Date: 23/03/2017 06:18:32 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_biditem](
	[bid_uid] [int] IDENTITY(1,1) NOT NULL,
	[bid_sub_uid] [int] NOT NULL,
	[bid_round] [int] NOT NULL,
	[bid_cli_uid] [int] NULL,
	[bid_mount] [numeric](32, 2) NULL,
	[bid_mountxfac] [numeric](32, 2) NOT NULL,
	[bid_date] [datetime2](0) NULL,
	[bid_xit_uid] [int] NOT NULL,
	[bid_flag0] [int] NOT NULL,
	[bid_flag1] [int] NOT NULL,
	[bid_doc] [varchar](50) NULL,
 CONSTRAINT [PK_mdl_biditem_bid_uid] PRIMARY KEY CLUSTERED 
(
	[bid_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_clixitem]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_clixitem](
	[clx_uid] [int] IDENTITY(1,1) NOT NULL,
	[clx_cli_uid] [int] NOT NULL,
	[clx_xit_uid] [int] NOT NULL,
	[clx_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_clixitem_clx_uid] PRIMARY KEY CLUSTERED 
(
	[clx_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_contents]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_contents](
	[con_uid] [int] IDENTITY(1,1) NOT NULL,
	[con_parent] [int] NULL DEFAULT (NULL),
	[con_level] [int] NULL DEFAULT (NULL),
	[con_position] [int] NULL DEFAULT (NULL),
	[con_createuser] [int] NULL DEFAULT (NULL),
	[con_createdate] [datetime2](0) NULL DEFAULT (NULL),
	[con_updateuser] [int] NULL DEFAULT (NULL),
	[con_updatedate] [datetime2](0) NULL DEFAULT (NULL),
	[con_delete] [int] NULL DEFAULT ((0)),
 CONSTRAINT [PK_mdl_contents_con_uid] PRIMARY KEY CLUSTERED 
(
	[con_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_contents_languages]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_contents_languages](
	[col_uid] [int] IDENTITY(1,1) NOT NULL,
	[col_con_uid] [int] NULL DEFAULT (NULL),
	[col_language] [varchar](10) NULL DEFAULT (N'es'),
	[col_title] [varchar](255) NULL DEFAULT (NULL),
	[col_description] [varchar](255) NULL DEFAULT (NULL),
	[col_content] [varchar](100) NULL,
	[col_url] [varchar](255) NULL DEFAULT (NULL),
	[col_metatitle] [varchar](100) NULL,
	[col_metadescription] [varchar](100) NULL,
	[col_metakeyword] [varchar](100) NULL,
	[col_media] [varchar](100) NULL,
	[col_image] [varchar](255) NULL DEFAULT (NULL),
	[col_status] [varchar](8) NULL DEFAULT (NULL),
 CONSTRAINT [PK_mdl_contents_languages_col_uid] PRIMARY KEY CLUSTERED 
(
	[col_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_currency]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_currency](
	[cur_uid] [int] IDENTITY(1,1) NOT NULL,
	[cur_description] [varchar](255) NOT NULL,
	[cur_delete] [smallint] NOT NULL,
 CONSTRAINT [PK_mdl_currency_cur_uid] PRIMARY KEY CLUSTERED 
(
	[cur_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_divisas]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_divisas](
	[div_uid] [int] IDENTITY(1,1) NOT NULL,
	[div_pca_uid] [int] NOT NULL,
	[div_usr_uid] [int] NOT NULL,
	[div_description] [varchar](255) NULL,
	[div_type] [varchar](6) NULL,
	[div_date] [date] NULL,
	[div_hour] [time](7) NULL,
	[div_mount_base] [numeric](20, 2) NULL,
	[div_moneda] [varchar](255) NULL,
	[div_mount_unidad] [numeric](20, 2) NULL,
	[div_hour_end] [datetime2](0) NULL,
	[div_tiempo] [int] NULL,
	[div_status] [varchar](8) NOT NULL,
	[div_delete] [int] NOT NULL,
	[div_deadtime] [datetime2](0) NOT NULL,
	[div_finish] [smallint] NOT NULL,
 CONSTRAINT [PK_mdl_divisas_div_uid] PRIMARY KEY CLUSTERED 
(
	[div_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_incoterm]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_incoterm](
	[inc_uid] [int] NOT NULL,
	[inc_cli_uid] [int] NOT NULL,
	[inc_sub_uid] [int] NOT NULL,
	[inc_lugar_entrega] [varchar](100) NOT NULL,
	[inc_tra_uid] [int] NOT NULL,
	[inc_inl_uid] [int] NOT NULL,
	[inc_ajuste] [int] NOT NULL,
	[inc_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_incoterm_inc_uid] PRIMARY KEY CLUSTERED 
(
	[inc_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_incoterm_language]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_incoterm_language](
	[inl_uid] [int] NOT NULL,
	[inl_name] [varchar](255) NOT NULL,
	[inl_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_incoterm_language_inl_uid] PRIMARY KEY CLUSTERED 
(
	[inl_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_japonesa]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_japonesa](
	[jap_uid] [int] IDENTITY(1,1) NOT NULL,
	[jap_sub_uid] [int] NOT NULL,
	[jap_pro_uid] [int] NOT NULL,
	[jap_cli_uid] [int] NULL,
	[jap_mount] [numeric](32, 2) NULL,
	[jap_mountxfac] [numeric](32, 2) NOT NULL,
	[jap_date] [datetime2](0) NULL,
	[jap_pca_uid] [int] NOT NULL,
 CONSTRAINT [PK_mdl_japonesa_jap_uid] PRIMARY KEY CLUSTERED 
(
	[jap_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_pro_category]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_pro_category](
	[pca_uid] [int] NOT NULL,
	[pca_name] [varchar](255) NULL DEFAULT (NULL),
	[pca_url] [varchar](255) NOT NULL,
	[pca_delete] [int] NOT NULL DEFAULT ((0)),
 CONSTRAINT [PK_mdl_pro_category_pca_uid] PRIMARY KEY CLUSTERED 
(
	[pca_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_product]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_product](
	[pro_uid] [int] NOT NULL,
	[pro_sub_uid] [int] NOT NULL,
	[pro_name] [varchar](255) NULL DEFAULT (NULL),
	[pro_url] [varchar](255) NOT NULL,
	[pro_quantity] [int] NULL DEFAULT (NULL),
	[pro_unidad] [varchar](255) NULL DEFAULT (NULL),
	[pro_description] [varchar](255) NULL,
	[pro_image] [varchar](255) NULL DEFAULT (NULL),
	[pro_document] [varchar](255) NULL DEFAULT (NULL),
 CONSTRAINT [PK_mdl_product_pro_uid] PRIMARY KEY CLUSTERED 
(
	[pro_uid] ASC,
	[pro_sub_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[mdl_roles]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_roles](
	[rol_uid] [int] NOT NULL,
	[rol_description] [varchar](255) NOT NULL,
	[rol_delete] [int] NOT NULL,
	[rol_status] [varchar](8) NOT NULL,
 CONSTRAINT [PK_mdl_roles_rol_uid] PRIMARY KEY CLUSTERED 
(
	[rol_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_roles_users]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_roles_users](
	[rus_uid] [int] NOT NULL,
	[rus_usr_uid] [int] NOT NULL,
	[rus_rol_uid] [int] NOT NULL,
 CONSTRAINT [PK_mdl_roles_users_rus_uid] PRIMARY KEY CLUSTERED 
(
	[rus_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_round]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_round](
	[rou_uid] [int] IDENTITY(1,1) NOT NULL,
	[rou_sub_uid] [int] NOT NULL,
	[rou_round] [int] NOT NULL,
	[rou_datetime] [datetime2](0) NOT NULL,
	[rou_flag0] [int] NOT NULL,
	[rou_flag1] [int] NOT NULL,
 CONSTRAINT [PK_mdl_round_rou_uid] PRIMARY KEY CLUSTERED 
(
	[rou_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_subasta]    Script Date: 14/3/2017 11:34:33 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_subasta](
	[sub_uid] [int] NOT NULL,
	[sub_pca_uid] [int] NOT NULL,
	[sub_usr_uid] [int] NOT NULL,
	[sub_sol_uid] [int] NULL,
	[sub_description] [varchar](255) NULL CONSTRAINT [DF__mdl_subas__sub_d__4AB81AF0]  DEFAULT (NULL),
	[sub_type] [varchar](6) NULL CONSTRAINT [DF__mdl_subas__sub_t__4BAC3F29]  DEFAULT (NULL),
	[sub_modalidad] [varchar](255) NULL CONSTRAINT [DF__mdl_subas__sub_m__4CA06362]  DEFAULT (NULL),
	[sub_date] [date] NULL CONSTRAINT [DF__mdl_subas__sub_d__4D94879B]  DEFAULT (NULL),
	[sub_hour] [time](7) NULL CONSTRAINT [DF__mdl_subas__sub_h__4E88ABD4]  DEFAULT (NULL),
	[sub_wheels] [int] NOT NULL CONSTRAINT [DF__mdl_subas__sub_w__4F7CD00D]  DEFAULT ((0)),
	[sub_mount_base] [numeric](20, 2) NULL CONSTRAINT [DF__mdl_subas__sub_m__5070F446]  DEFAULT (NULL),
	[sub_mountdead] [numeric](32, 2) NOT NULL CONSTRAINT [DF__mdl_subas__sub_m__5165187F]  DEFAULT ((0.00)),
	[sub_moneda] [varchar](255) NULL CONSTRAINT [DF__mdl_subas__sub_m__52593CB8]  DEFAULT (NULL),
	[sub_moneda1] [int] NOT NULL CONSTRAINT [DF__mdl_subas__sub_m__534D60F1]  DEFAULT ((0)),
	[sub_mount_unidad] [numeric](20, 2) NULL CONSTRAINT [DF__mdl_subas__sub_m__5441852A]  DEFAULT (NULL),
	[sub_hour_end] [datetime2](0) NULL CONSTRAINT [DF__mdl_subas__sub_h__5535A963]  DEFAULT (NULL),
	[sub_tiempo] [int] NULL CONSTRAINT [DF__mdl_subas__sub_t__5629CD9C]  DEFAULT ((0)),
	[sub_status] [varchar](8) NOT NULL CONSTRAINT [DF__mdl_subas__sub_s__571DF1D5]  DEFAULT (N'ACTIVE'),
	[sub_delete] [int] NOT NULL,
	[sub_deadtime] [datetime2](0) NOT NULL,
	[sub_finish] [smallint] NOT NULL CONSTRAINT [DF__mdl_subas__sub_f__5812160E]  DEFAULT ((0)),
	[sub_mode] [varchar](7) NOT NULL CONSTRAINT [DF__mdl_subas__sub_m__59063A47]  DEFAULT (N'SUBASTA'),
 CONSTRAINT [PK_mdl_subasta] PRIMARY KEY CLUSTERED 
(
	[sub_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_subasta_informe]    Script Date: 14/3/2017 11:34:34 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_subasta_informe](
	[sua_uid] [smallint] IDENTITY(1,1) NOT NULL,
	[sua_user_uid] [int] NOT NULL,
	[sua_sub_uid] [int] NULL,
	[sua_elaborado] [varchar](50) NOT NULL,
	[sua_aprobado] [varchar](50) NOT NULL,
	[sua_observaciones] [varchar](150) NOT NULL,
	[sua_date] [datetime] NULL,
	[sua_ahorro] [decimal](18, 2) NULL,
	[sua_monto] [decimal](18, 2) NULL,
	[sua_status] [varchar](8) NULL,
	[sua_usr_apr] [int] null,
 CONSTRAINT [PK_mdl_adjudicar] PRIMARY KEY CLUSTERED 
(
	[sua_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_subasta_aprobar]    Script Date: 06/02/2017 06:16:41 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_subasta_aprobar](
	[sup_uid] [int] IDENTITY(1,1) NOT NULL,
	[sup_sub_uid] [int] NOT NULL,
	[sup_user_uid] [int] NOT NULL,
	[sup_date] [datetime] NOT NULL,
	[sup_status] [varchar](8) NOT NULL,
 CONSTRAINT [PK_mdl_subasta_aprobar] PRIMARY KEY CLUSTERED 
(
	[sup_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_terminos]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_terminos](
	[ter_uid] [int] IDENTITY(1,1) NOT NULL,
	[ter_sub_uid] [int] NOT NULL,
	[ter_cli_uid] [int] NOT NULL,
	[ter_datetime] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_mdl_terminos_ter_uid] PRIMARY KEY CLUSTERED 
(
	[ter_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_tipologia]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_tipologia](
	[tip_uid] [int] IDENTITY(1,1) NOT NULL,
	[tip_descrip] [varchar](50) NOT NULL,
 CONSTRAINT [PK_mdl_tipologia] PRIMARY KEY CLUSTERED 
(
	[tip_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_transporte]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_transporte](
	[tra_uid] [int] NOT NULL,
	[tra_name] [varchar](255) NOT NULL,
	[tra_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_transporte_tra_uid] PRIMARY KEY CLUSTERED 
(
	[tra_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_users]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_users](
	[mus_uid] [int] IDENTITY(1,1) NOT NULL,
	[mus_login] [varchar](40) NULL,
	[mus_pass] [varchar](40) NULL,
	[mus_firstname] [varchar](40) NULL,
	[mus_lastname] [varchar](40) NULL,
	[mus_email] [varchar](40) NULL,
	[mus_phone] [varchar](24) NULL,
	[mus_fax] [varchar](16) NULL,
	[mus_cellular] [varchar](16) NULL,
	[mus_address] [varchar](100) NULL,
	[mus_status] [varchar](8) NULL,
	[mus_delete] [int] NOT NULL,
	[mus_uid_old] [varchar](100) NULL,
	[mus_pass_old] [varchar](255) NULL,
	[mus_photo] [varchar](100) NULL,
 CONSTRAINT [PK_mdl_users_mus_uid] PRIMARY KEY CLUSTERED 
(
	[mus_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] 

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_xitem]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_xitem](
	[xit_uid] [int] NOT NULL,
	[xit_sub_uid] [int] NOT NULL,
	[xit_product] [varchar](255) NOT NULL,
	[xit_description] [varchar](255) NOT NULL,
	[xit_image] [varchar](255) NOT NULL,
	[xit_price] [numeric](32, 2) NOT NULL,
	[xit_unity] [int] NOT NULL,
	[xit_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_xitem_xit_uid] PRIMARY KEY CLUSTERED 
(
	[xit_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[sys_item]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[sys_item](
	[ite_uid] [int] IDENTITY(1,1) NOT NULL,
	[ite_sub_uid] [int] NOT NULL,
	[ite_wheel] [int] NOT NULL,
	[ite_flag] [int] NOT NULL DEFAULT ((0)),
 CONSTRAINT [PK_sys_item_ite_uid] PRIMARY KEY CLUSTERED 
(
	[ite_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[sys_labels]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[sys_labels](
	[lab_uid] [varchar](255) NOT NULL,
	[lab_category] [varchar](255) NOT NULL,
	[lab_language] [varchar](2) NOT NULL,
	[lab_label] [varchar](255) NOT NULL,
	[lab_status] [varchar](8) NOT NULL DEFAULT (N'ACTIVE'),
	[lab_delete] [int] NOT NULL DEFAULT ((0)),
 CONSTRAINT [PK_sys_labels_lab_uid] PRIMARY KEY CLUSTERED 
(
	[lab_uid] ASC,
	[lab_language] ASC,
	[lab_category] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[sys_language]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[sys_language](
	[lan_uid] [int] IDENTITY(1,1) NOT NULL,
	[lan_language] [varchar](100) NULL,
	[lan_code] [varchar](2) NULL,
	[lan_status] [varchar](8) NULL,
	[lan_delete] [int] NULL,
 CONSTRAINT [PK_sys_language_lan_uid] PRIMARY KEY CLUSTERED 
(
	[lan_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[sys_log]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[sys_log](
	[log_uid] [int] IDENTITY(1,1) NOT NULL,
	[log_sql] [varchar](255) NOT NULL,
 CONSTRAINT [PK_sys_log_log_uid] PRIMARY KEY CLUSTERED 
(
	[log_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[sys_modules]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[sys_modules](
	[mod_uid] [int] NOT NULL,
	[mod_language] [varchar](2) NOT NULL,
	[mod_alias] [varchar](50) NOT NULL,
	[mod_parent] [int] NOT NULL,
	[mod_name] [varchar](255) NOT NULL,
	[mod_lab_uid] [varchar](255) NOT NULL,
	[mod_lab_category] [varchar](255) NOT NULL,
	[mod_position] [int] NOT NULL,
	[mod_delete] [int] NOT NULL DEFAULT ((0)),
	[mod_status] [varchar](8) NOT NULL,
	[mod_index] [varchar](255) NOT NULL,
 CONSTRAINT [PK_sys_modules_mod_uid] PRIMARY KEY CLUSTERED 
(
	[mod_uid] ASC,
	[mod_language] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[sys_modules_access]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[sys_modules_access](
	[moa_uid] [int] IDENTITY(1,1) NOT NULL,
	[moa_rol_uid] [int] NOT NULL,
	[moa_mop_uid] [int] NOT NULL,
	[moa_status] [varchar](8) NOT NULL,
 CONSTRAINT [PK_sys_modules_access] PRIMARY KEY CLUSTERED 
(
	[moa_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[sys_modules_options]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[sys_modules_options](
	[mop_uid] [int] IDENTITY(1,1) NOT NULL,
	[mop_mod_uid] [int] NOT NULL DEFAULT ((0)),
	[mop_lab_category] [varchar](255) NOT NULL,
	[mop_status] [varchar](8) NOT NULL,
 CONSTRAINT [PK_sys_modules_options_mop_uid] PRIMARY KEY CLUSTERED 
(
	[mop_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[sys_modules_users]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[sys_modules_users](
	[mus_uid] [int] IDENTITY(1,1) NOT NULL,
	[mus_mod_uid] [int] NULL DEFAULT (NULL),
	[mus_rol_uid] [int] NULL DEFAULT (NULL),
	[mus_place] [varchar](7) NULL DEFAULT (NULL),
	[mus_delete] [int] NULL DEFAULT (NULL),
 CONSTRAINT [PK_sys_modules_users_mus_uid] PRIMARY KEY CLUSTERED 
(
	[mus_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[sys_session]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[sys_session](
	[ses_uid] [bigint] IDENTITY(1,1) NOT NULL,
	[ses_user_uid] [int] NOT NULL,
	[ses_useragent] [varchar](255) NOT NULL,
	[ses_skey] [varchar](50) NOT NULL,
	[ses_ipaddress] [varchar](20) NOT NULL,
	[ses_lastactivity] [int] NOT NULL,
	[ses_registered] [char](1) NOT NULL,
 CONSTRAINT [PK_sys_session_ses_uid] PRIMARY KEY CLUSTERED 
(
	[ses_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[sys_users]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[sys_users](
	[usr_uid] [int] NOT NULL,
	[usr_login] [varchar](255) NOT NULL,
	[usr_pass] [varchar](255) NOT NULL,
	[usr_firstname] [varchar](255) NOT NULL,
	[usr_lastname] [varchar](255) NOT NULL,
	[usr_email] [varchar](255) NOT NULL,
	[usr_phone] [varchar](24) NULL CONSTRAINT [DF__sys_users__usr_p__06CD04F7]  DEFAULT (NULL),
	[usr_fax] [varchar](16) NULL CONSTRAINT [DF__sys_users__usr_f__07C12930]  DEFAULT (NULL),
	[usr_cellular] [varchar](16) NULL CONSTRAINT [DF__sys_users__usr_c__08B54D69]  DEFAULT (NULL),
	[usr_address] [varchar](100) NULL,
	[usr_status] [varchar](8) NULL CONSTRAINT [DF__sys_users__usr_s__09A971A2]  DEFAULT (N'ACTIVE'),
	[usr_delete] [int] NOT NULL CONSTRAINT [DF__sys_users__usr_d__0A9D95DB]  DEFAULT ((0)),
	[usr_uid_old] [varchar](100) NULL CONSTRAINT [DF__sys_users__usr_u__0B91BA14]  DEFAULT (NULL),
	[usr_pass_old] [varchar](255) NULL CONSTRAINT [DF__sys_users__usr_p__0C85DE4D]  DEFAULT (NULL),
	[usr_date] [datetime2](0) NULL,
	[usr_photo] [varchar](255) NULL,
 CONSTRAINT [PK_sys_users_usr_uid] PRIMARY KEY CLUSTERED 
(
	[usr_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[sys_users_verify]    Script Date: 03/02/2017 02:31:55 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[sys_users_verify](
	[suv_uid] [int] IDENTITY(1,1) NOT NULL,
	[suv_cli_uid] [int] NULL DEFAULT (NULL),
	[suv_token] [varchar](255) NULL DEFAULT (NULL),
	[suv_date] [datetime2](0) NULL DEFAULT (NULL),
	[suv_ip] [varchar](255) NULL DEFAULT (NULL),
	[suv_status] [int] NULL DEFAULT ((0)),
 CONSTRAINT [PK_sys_users_verify_suv_uid] PRIMARY KEY CLUSTERED 
(
	[suv_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_client]    Script Date: 2/20/2017 6:46:50 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING OFF
GO
CREATE TABLE [dbo].[mdl_client](
	[cli_uid] [int] IDENTITY(1,1) NOT NULL,
	[cli_nit_ci] [varchar](255) NOT NULL,
	[cli_interno] [varchar](255) NOT NULL,
	[cli_lec_uid] [int] NOT NULL,
	[cli_cov_uid] [int] NOT NULL,
	[cli_socialreason] [varchar](255) NOT NULL,
	[cli_legaldirection] [varchar](255) NULL,
	[cli_phone] [varchar](255) NULL,
	[cli_mainemail] [varchar](255) NOT NULL,
	[cli_commercialemail] [varchar](255) NULL,
	[cli_legal_ci] [varchar](255) NOT NULL,
	[cli_legalname] [varchar](255) NOT NULL,
	[cli_legallastname] [varchar](255) NOT NULL,
	[cli_legal_ci2] [varchar](255) NULL,
	[cli_legalname2] [varchar](255) NULL,
	[cli_legallastname2] [varchar](255) NULL,
	[cli_legal_ci3] [varchar](255) NULL,
	[cli_legalname3] [varchar](255) NULL,
	[cli_legallastname3] [varchar](255) NULL,
	[cli_commercialname] [varchar](255) NULL,
	[cli_commerciallastname] [varchar](255) NULL,
	[cli_user] [varchar](50) NOT NULL,
	[cli_password] [varchar](50) NOT NULL,
	[cli_pass_change] [bit] NULL,
	[cli_item_uid] [int] NOT NULL,
	[cli_ite_uid] [int] NOT NULL,
	[cli_logo] [varchar](255) NULL,
	[cli_pts_uid] [int] NOT NULL,
	[cli_status] [int] NOT NULL,
	[cli_status_main] [int] NOT NULL,
	[cli_delete] [int] NOT NULL,
	[cli_date] [datetime2](0) NOT NULL,
	[cli_type] [smallint] NULL CONSTRAINT [DF_mdl_client_cli_type]  DEFAULT ((1)),
 CONSTRAINT [PK_mdl_client_cli_uid] PRIMARY KEY CLUSTERED 
(
	[cli_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_documents]    Script Date: 14/2/2017 12:22:04 a. m. ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[mdl_documents](
	[doc_uid] [int] IDENTITY(1,1) NOT NULL,
	[doc_name] [varchar](255) NOT NULL,
	[doc_status] [varchar](8) NOT NULL,
	[doc_delete] [bit] NOT NULL,
 CONSTRAINT [PK_mdl_documents] PRIMARY KEY CLUSTERED 
(
	[doc_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_documentsclient]    Script Date: 14/2/2017 12:22:29 a. m. ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[mdl_documentsclient](
	[dcl_uid] [int] IDENTITY(1,1) NOT NULL,
	[dcl_cli_uid] [int] NOT NULL,
	[dcl_doc_uid] [int] NOT NULL,
 CONSTRAINT [PK_mdl_documentsclient] PRIMARY KEY CLUSTERED 
(
	[dcl_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_legalclassification]    Script Date: 14/2/2017 12:23:02 a. m. ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[mdl_legalclassification](
	[lec_uid] [int] IDENTITY(1,1) NOT NULL,
	[lec_name] [varchar](50) NOT NULL,
	[lec_status] [varchar](8) NOT NULL,
	[lec_delete] [bit] NOT NULL,
 CONSTRAINT [PK_mdl_legalclassification] PRIMARY KEY CLUSTERED 
(
	[lec_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_paymenttosupplier]    Script Date: 14/2/2017 12:23:41 a. m. ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[mdl_paymenttosupplier](
	[pts_uid] [int] IDENTITY(1,1) NOT NULL,
	[pts_type] [varchar](50) NOT NULL,
	[pts_status] [varchar](8) NOT NULL,
	[pts_delete] [bit] NOT NULL,
 CONSTRAINT [PK_mdl_paymenttosupplier] PRIMARY KEY CLUSTERED 
(
	[pts_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

SET ANSI_PADDING ON
GO

/****** Object:  Table [dbo].[mdl_unidad]    Script Date: 22/02/2017 11:27:09 a.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_unidad](
	[uni_uid] [int] IDENTITY(1,1) NOT NULL,
	[uni_description] [varchar](50) NOT NULL,
	[uni_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_unidad] PRIMARY KEY CLUSTERED 
(
	[uni_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

/****** Object:  Table [dbo].[mdl_rav]    Script Date: 22/02/2017 02:14:23 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_rav](
	[rav_uid] [int] NOT NULL,
	[rav_rol_uid] [int] NOT NULL,
	[rav_monto_inf] [decimal](18, 0) NOT NULL,
	[rav_monto_sup] [decimal](18, 0) NOT NULL,
	[rav_tipologia] [int] NOT NULL,
	[rav_cur_uid] [int] NOT NULL,
	[rav_delete] [int] NOT NULL,
	[rav_status] [varchar](8) NOT NULL,
 CONSTRAINT [PK_mdl_rav] PRIMARY KEY CLUSTERED 
(
	[rav_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[mdl_rav_access]    Script Date: 22/02/2017 03:23:43 p.m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_rav_access](
	[raa_uid] [int] IDENTITY(1,1) NOT NULL,
	[raa_rav_uid] [int] NOT NULL,
	[raa_uni_uid] [int] NOT NULL,
 CONSTRAINT [PK_mdl_rav_access] PRIMARY KEY CLUSTERED 
(
	[raa_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_coverage]    Script Date: 2/23/2017 1:29:14 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[mdl_coverage](
	[cov_uid] [int] IDENTITY(1,1) NOT NULL,
	[cov_name] [varchar](255) NOT NULL,
	[cov_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_coverage] PRIMARY KEY CLUSTERED 
(
	[cov_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[mdl_item]    Script Date: 2/23/2017 1:19:29 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[mdl_item](
	[ite_uid] [int] IDENTITY(1,1) NOT NULL,
	[ite_name] [varchar](255) NOT NULL,
	[ite_item] [int] NOT NULL,
	[ite_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_item] PRIMARY KEY CLUSTERED 
(
	[ite_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[mdl_way_desc]    Script Date: 2/23/2017 1:20:21 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[mdl_way_desc](
	[wde_uid] [int] IDENTITY(1,1) NOT NULL,
	[wde_cli_uid] [int] NOT NULL,
	[wde_wtp_uid] [int] NOT NULL,
	[wde_description] [varchar](255) NOT NULL,
	[wde_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_way_desc] PRIMARY KEY CLUSTERED 
(
	[wde_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[mdl_waytopay]    Script Date: 2/23/2017 1:20:38 AM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[mdl_waytopay](
	[wtp_uid] [int] IDENTITY(1,1) NOT NULL,
	[wtp_pts_uid] [int] NOT NULL,
	[wtp_name] [varchar](255) NOT NULL,
	[wtp_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_waytopay] PRIMARY KEY CLUSTERED 
(
	[wtp_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[mdl_categoria1]    Script Date: 26/2/2017 9:08:40 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_categoria1](
	[ca1_uid] [int] IDENTITY(1,1) NOT NULL,
	[ca1_description] [varchar](50) NOT NULL,
	[ca1_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_categoria1] PRIMARY KEY CLUSTERED 
(
	[ca1_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_categoria2]    Script Date: 26/2/2017 9:08:40 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_categoria2](
	[ca2_uid] [int] IDENTITY(1,1) NOT NULL,
	[ca2_ca1_uid] [int] NOT NULL,
	[ca2_description] [varchar](50) NOT NULL,
	[ca2_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_categoria2] PRIMARY KEY CLUSTERED 
(
	[ca2_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_categoria3]    Script Date: 26/2/2017 9:08:40 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_categoria3](
	[ca3_uid] [int] IDENTITY(1,1) NOT NULL,
	[ca3_ca2_uid] [int] NOT NULL,
	[ca3_description] [varchar](50) NOT NULL,
	[ca3_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_categoria3] PRIMARY KEY CLUSTERED 
(
	[ca3_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
SET ANSI_NULLS ON
GO
/****** Object:  Table [dbo].[mdl_solicitud_compra]    Script Date: 4/3/2017 8:37:47 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_solicitud_compra](
	[sol_uid] [int] NOT NULL,
	[sol_date] [datetime] NOT NULL,
	[sol_usu_uid] [int] NOT NULL,
	[sol_observaciones] [varchar](150) NOT NULL,
	[sol_doc] [varchar](50) NULL,
	[sol_monto] [decimal](10, 2) NULL,
	[sol_moneda] [int] NULL,
	[sol_apr_uid] [int] NOT NULL,
	[sol_apr_date] [datetime] NOT NULL,
	[sol_imp_date] [datetime] NOT NULL,
	[sol_estado] [int] NOT NULL,
	[sol_status] [varchar](10) NOT NULL,
	[sol_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_solicitud_compra] PRIMARY KEY CLUSTERED 
(
	[sol_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[mdl_solicitud_material]    Script Date: 1/3/2017 2:14:15 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_solicitud_material](
	[som_uid] [int] IDENTITY(1,1) NOT NULL,
	[som_sol_uid] [int] NOT NULL,
	[som_ca1_uid] [int] NOT NULL,
	[som_ca2_uid] [int] NOT NULL,
	[som_ca3_uid] [int] NOT NULL,
	[som_description] [varchar](50) NOT NULL,
	[som_cantidad] [int] NOT NULL,
	[som_unidad] [varchar](50) NOT NULL,
	[som_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_solicitud_material] PRIMARY KEY CLUSTERED 
(
	[som_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_solicitud_proveedor]    Script Date: 1/3/2017 2:14:15 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_solicitud_proveedor](
	[sop_uid] [int] IDENTITY(1,1) NOT NULL,
	[sop_sol_uid] [int] NOT NULL,
	[sop_cli_uid] [int] NOT NULL,
	[sop_date] [datetime] NOT NULL,
	[sop_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_solicitud_proveedor] PRIMARY KEY CLUSTERED 
(
	[sop_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_solicitud_unidad]    Script Date: 1/3/2017 2:14:15 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_solicitud_unidad](
	[sou_uid] [int] IDENTITY(1,1) NOT NULL,
	[sou_uni_uid] [int] NOT NULL,
	[sou_sol_uid] [int] NOT NULL,
 CONSTRAINT [PK_mdl_solicitud_unidad] PRIMARY KEY CLUSTERED 
(
	[sou_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[mdl_orden_compra]    Script Date: 3/3/2017 1:51:29 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_orden_compra](
	[orc_uid] [int] NOT NULL,
	[orc_sol_uid] [int] NOT NULL,
	[orc_nro_oc] [varchar](50) NOT NULL,
	[orc_monto] [decimal](10, 2) NULL,
	[orc_moneda] [int] NULL,
	[orc_fecha] [date] NOT NULL,
	[orc_hora] [time](7) NOT NULL,
	[orc_cli_uid] [int] NOT NULL,
	[orc_aprobado] [varchar](50) NOT NULL,
	[orc_usr_uid] [int] NOT NULL,
	[orc_datetime] [datetime] NOT NULL,
	[orc_aprusr_uid] [int] NULL,
	[orc_apr_datetime] [datetime] NULL,
	[orc_document] [varchar](50) NULL,
	[orc_estado] [int] NOT NULL,
	[orc_status] [varchar](10) NOT NULL,
	[orc_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_ordenes_compra] PRIMARY KEY CLUSTERED 
(
	[orc_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_orden_unidad]    Script Date: 3/3/2017 1:51:29 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_orden_unidad](
	[oru_uid] [int] IDENTITY(1,1) NOT NULL,
	[oru_orc_uid] [int] NOT NULL,
	[oru_uni_uid] [int] NOT NULL,
 CONSTRAINT [PK_mdl_orden_unidad] PRIMARY KEY CLUSTERED 
(
	[oru_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

/****** Object:  Table [dbo].[mdl_notificacion_template]    Script Date: 4/3/2017 3:32:25 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_notificacion_template](
	[not_uid] [int] IDENTITY(1,1) NOT NULL,
	[not_subject] [varchar](150) NOT NULL,
	[not_template] [text] NULL,
	[not_tip_uid] [int] NOT NULL,
	[not_sign] [varchar](255) NOT NULL,
	[not_usr_uid] [int] NOT NULL,
	[not_fecha] [datetime] NOT NULL,
	[not_status] [varchar](10) NOT NULL,
	[not_delete] [int] NOT NULL,
 CONSTRAINT [PK_mdl_notificacion_template] PRIMARY KEY CLUSTERED 
(
	[not_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[mdl_notificacion_tipologia]    Script Date: 4/3/2017 3:32:25 a. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_notificacion_tipologia](
	[nti_uid] [int] IDENTITY(1,1) NOT NULL,
	[nti_description] [varchar](50) NOT NULL,
 CONSTRAINT [PK_mdl_notificacion_tipologia] PRIMARY KEY CLUSTERED 
(
	[nti_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[mdl_notificacion_envio]    Script Date: 5/3/2017 5:15:58 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_notificacion_envio](
	[noe_uid] [int] IDENTITY(1,1) NOT NULL,
	[noe_cli_uid] [int] NOT NULL,
	[noe_email] [varchar](50) NOT NULL,
	[noe_sol_uid] [int] NULL,
	[noe_orc_uid] [int] NULL,
	[noe_nro_oc] [varchar](50) NULL,
	[noe_nti_uid] [int] NOT NULL,
	[noe_attach_exist] [int] NOT NULL,
	[noe_attach] [varchar](50) NULL,
	[noe_status] [int] NOT NULL,
	[noe_retry] [int] NULL,
	[noe_fecha] [datetime] NOT NULL,
	[noe_fecha_envio] [datetime] NULL,
	[noe_response] [varchar](250) NULL,
 CONSTRAINT [PK_mdl_notificacion_envio] PRIMARY KEY CLUSTERED 
(
	[noe_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[mdl_subasta_unidad]    Script Date: 4/3/2017 7:55:02 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[mdl_subasta_unidad](
	[suu_uid] [int] IDENTITY(1,1) NOT NULL,
	[suu_sub_uid] [int] NOT NULL,
	[suu_uni_uid] [int] NOT NULL,
 CONSTRAINT [PK_mdl_subasta_unidad] PRIMARY KEY CLUSTERED 
(
	[suu_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO

/****** Object:  Table [dbo].[mdl_import]    Script Date: 8/14/2017 3:38:27 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[mdl_import](
	[imp_uid] [int] IDENTITY(1,1) NOT NULL,
	[imp_datetime] [datetime] NULL,
	[imp_type] [int] NULL,
	[imp_status] [varchar](10) NULL,
	[imp_delete] [int] NULL,
	[imp_usu_uid] [int] NULL,
	[imp_reset] [int] NULL,
 CONSTRAINT [PK_mdl_import] PRIMARY KEY CLUSTERED 
(
	[imp_uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO